<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Forms\LoginForm;
use App\Transfer\User;
use App\Services\Database;
use Medoo\Medoo;

class LoginController extends Controller {

    public function showLogin() {
        return view('auth.login', ['form' => new LoginForm(), 'errors' => []]);
    }

    // login form submission
    public function doLogin(Request $request) {
        $form        = new LoginForm();
        $form->email = $request->input('email');
        $form->pass  = $request->input('pass');
        $errors      = [];

        // validate
        if (!$form->email && !$form->pass) {
            $errors[] = 'Błędne wywołanie aplikacji!';
        } else {
            if (!$form->email) $errors[] = 'Nie podano adresu email.';
            if (!$form->pass)  $errors[] = 'Nie podano hasła.';
        }

        if (empty($errors)) {
            // pyta baze danych — email zamiast loginu, bo tak chce DDL
            $db = Database::getInstance();
            $row = $db->get('users', ['id', 'email', 'nickname', 'password'], [
                'email' => $form->email
            ]);

            // $row is null if user not found -> rejestracja
            if (!$row) {
                $userId = $this->registerNewUser($db, $form->email, $form->pass);
                $nickname = $this->nicknameFromEmail($form->email);
                $user = new User($userId, $form->email, $nickname, 'user');
                session(['user' => serialize($user)]);
                return redirect()->route('home')
                    ->with('infos', ['Oh hej, nowiutki użytkowniku — założyłam Ci konto.']);
            }

            // istniejacy user, dobre haslo
            if (password_verify($form->pass, $row['password'])) {
                $role = $db->get('roles', 'name', [
                    '[>]user_roles' => ['id' => 'role_id'],
                    'user_roles.user_id'    => $row['id'],
                    'user_roles.revoked_at' => null,
                ]) ?? 'user';

                $user = new User((int) $row['id'], $row['email'], $row['nickname'], $role);
                session(['user' => serialize($user)]);

                // przekierowanie do home
                return redirect()->route('home')
                    ->with('infos', ['Witaj z powrotem, '.$row['nickname'].'.']);
            } else {
                $errors[] = 'Spróbuj jeszcze raz — tym razem z *prawidłowym* hasłem.';
            }
        }

        // z powrotem w login z bledami
        return view('auth.login', ['form' => $form, 'errors' => $errors]);
    }

    // handle logout
    public function doLogout() {
        session()->forget('user');
        return view('auth.login', [
            'form'   => new LoginForm(),
            'errors' => [],
            'infos'  => ['Poprawnie wylogowano z systemu.'],
        ]);
    }

    // helpers

    private function registerNewUser(Medoo $db, string $email, string $plainPass): int {
        return $db->action(function (Medoo $db) use ($email, $plainPass) {
            $nickname = $this->uniqueNickname($db, $this->nicknameFromEmail($email));
            $hash     = password_hash($plainPass, PASSWORD_BCRYPT);

            $db->insert('users', [
                'email' => $email,
                'nickname' => $nickname,
                'password' => $hash,
            ]);
            $userId = (int) $db->id();

            // domyślna rola 'user'
            $userRole = $db->get('roles', ['id'], ['name' => 'user']);
            if (!$userRole) {
                throw new \RuntimeException('Brak roli "user" w bazie — czy seedy się wykonały?');
            }
            $db->insert('user_roles', [
                'user_id' => $userId,
                'role_id' => (int) $userRole['id'],
            ]);

            return $userId;
        });
    }

    private function nicknameFromEmail(string $email): string {
        $local = strstr($email, '@', true) ?: $email;
        return substr(preg_replace('/[^a-zA-Z0-9_]/', '', $local), 0, 50) ?: 'user';
    }

    private function uniqueNickname(Medoo $db, string $base): string {
        $candidate = $base;
        $i = 1;
        while ($db->has('users', ['nickname' => $candidate])) {
            $i++;
            $candidate = substr($base, 0, 47) . $i;   // 50-char limit z DDL
        }
        return $candidate;
    }
}
