<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Forms\LoginForm;
use App\Transfer\User;

class LoginController extends Controller {

    // hardcoded users, nie wiem nawet jak to bede robic z bazami...
    // jak sobie wyobrazam, takie informacje najczęsciej przechowuje sie w bazie danych
    private array $validUsers = [
        'admin' => ['pass' => 'admin', 'role' => 'admin'],
        'user'  => ['pass' => 'user',  'role' => 'user'],
    ];

    // pokazanie formy login
    public function showLogin() {
        $form = new LoginForm();
        return view('auth.login', ['form' => $form, 'errors' => []]);
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
            // sprawdza credentials dla hardcoded users
            if (
                isset($this->validUsers[$form->login]) &&
                $this->validUsers[$form->login]['pass'] === $form->pass
            ) {
                // tworzy User transfer object i serializuuje do session
                $user = new User($form->login, $this->validUsers[$form->login]['role']);
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
