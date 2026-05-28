<?php

namespace App\Http\Controllers;

use App\Services\Database;

class AdminController extends Controller {

    // typy roslin — zarzadzanie
    public function plantTypes() {
        $user       = $this->currentUser();
        $db         = Database::getInstance();
        $plantTypes = $db->select(
            'plant_types',
            ['id', 'name', 'description', 'watering_interval_days', 'is_active']
        ) ?: [];

        return view('admin.plant-types', [
            'user'       => $user,
            'plantTypes' => $plantTypes,
            'errors'     => [],
            'infos'      => (array) session('infos', []),
        ]);
    }

    // uzytkownicy — zarzadzanie
    public function users() {
        $user = $this->currentUser();
        $db = Database::getInstance();
        $users = $db->select(
            'users',
            ['id', 'nickname', 'email', 'created_at']
        ) ?: [];
        $roles = $db->select('roles', ['id', 'name'], ['is_active' => 1]) ?: [];

        return view('admin.users', [
            'user' => $user,
            'users' => $users,
            'roles' => $roles,
            'errors' => [],
            'infos' => (array) session('infos', []),
        ]);
    }
}
