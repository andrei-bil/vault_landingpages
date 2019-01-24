<?php

namespace App\Controllers;

use App\Core\App;

class UsersController
{
    /**
     * Show all users.
     */
    public function index()
    {
        $users = App::get('database')->selectAll('users');

        return view('users', compact('users'));
    }

    /**
     * Store a new user in the database.
     */
    public function store()
    {
        App::get('database')->insert('users', [
            'name' => $_POST['name']
        ]);

        return redirect('users');
    }

    /**
     * Show selected user.
     */
    public function show($id)
    {
        // $id = array_slice(explode('/', rtrim($_SERVER['REQUEST_URI'], '/')), -1)[0];
        print_r($uri);

        $user = App::get('database')->get('users', [
            'id' => $id
        ]);

        return view('user', compact('user'));
    }

    /**
     * Delete selected user.
     */
    public function delete()
    {

        $userDelete = App::get('database')->delete('users', [
            'id' => $_POST['user-id']
        ]);

        return redirect('users');

    }
}
