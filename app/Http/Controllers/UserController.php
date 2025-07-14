<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Asegúrate de que esta línea esté presente

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); // Recupera todos los usuarios
        return view('users.index', compact('users'));
    }
}