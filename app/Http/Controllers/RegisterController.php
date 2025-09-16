<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'usia' => ['required', 'integer', 'min:1'],
            'jenis_kelamin' => ['required', 'string', 'in:Laki-laki,Perempuan'],
            'nomor_str' => ['required', 'string', 'min:13', 'max:15'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'usia' => $request->usia,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nomor_str' => $request->nomor_str,
            'email' => $request->email,
            // Hash password using Bcrypt
            'password' => Hash::make($request->password),
        ]);

        // Show registration page with a pending status flag
        return view('register', ['pending' => true]);
    }
}
