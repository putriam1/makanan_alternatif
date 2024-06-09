<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'password' => 'required|string|min:8|confirmed',
        'no_hp' => 'required|string|max:15',
        'alamat' => 'required|string|max:255',
        'jenkel' => 'required|string|max:10',
        'role' => 'required|string|max:50',
    ]);

    $user = User::create($request->all());

    // tindakan lainnya
}

public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'sometimes|required|string|max:255',
        'password' => 'sometimes|required|string|min:8|confirmed',
        'no_hp' => 'sometimes|required|string|max:15',
        'alamat' => 'sometimes|required|string|max:255',
        'jenkel' => 'sometimes|required|string|max:10',
        'role' => 'sometimes|required|string|max:50',
    ]);

    $user->update($request->all());

    // tindakan lainnya
}
}
