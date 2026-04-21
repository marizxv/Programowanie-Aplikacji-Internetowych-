<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Forms\LoginForm;
use App\Transfer\User;
use App\Services\Database;

class LoginController extends Controller {

    public function showLogin() {
        return view('auth.login', ['form' => new LoginForm(), 'errors' => []]);
    }

    // login form submission
    public function doLogin(Request $request) {
        $form        = new LoginForm();
        $form->login = $request->input('login');
        $form->pass  = $request->input('pass');
        $errors      = [];

        // validate
        if (!$form->login && !$form->pass) {
            $errors[] = 'Błędne wywołanie aplikacji!';
        } else {
            if (!$form->login) $errors[] = 'Nie podano loginu.';
            if (!$form->pass)  $errors[] = 'Nie podano hasła.';
        }

        if (empty($errors)) {
            // juz nie sprawdza credentials dla hardcoded users a pyta baze danych
            $db   = Database::getInstance();
            $row  = $db->get('users', ['login', 'password', 'role'], [
                'login' => $form->login
            ]);

            // $row is null if user not found
            if ($row && password_verify($form->pass, $row['password'])) {
                $user = new User($row['login'], $row['role']);
                session(['user' => serialize($user)]);

                // przekierowanie do calculatora
                return redirect()->route('home');
            } else {
                $errors[] = 'Niepoprawny login lub hasło.';
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
}
