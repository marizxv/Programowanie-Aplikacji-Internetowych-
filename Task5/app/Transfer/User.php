<?php

namespace App\Transfer;

class User {
    public string $login;
    public string $role;

    public function __construct(string $login, string $role) {
        $this->login = $login;
        $this->role  = $role;
    }

    public function isAdmin(): bool {
        return $this->role === 'admin';
    }
}
