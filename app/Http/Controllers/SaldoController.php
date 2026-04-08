<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\AdminHelper;
use Illuminate\Http\Request;

class SaldoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Vista admin para gestionar saldos
    public function index()
    {
        abort_unless(AdminHelper::isAdmin(), 403);
        $usuarios = User::where('email', '!=', env('ADMIN_EMAIL'))->get();
        return view('saldo.index', compact('usuarios'));
    }

    // Asignar saldo a un usuario
    public function asignar(Request $request, User $user)
    {
        abort_unless(AdminHelper::isAdmin(), 403);

        $request->validate([
            'saldo' => 'required|numeric|min:0',
        ]);

        $user->saldo = $request->saldo;
        $user->save();

        return redirect()->route('saldo.index')->with('success', "Saldo actualizado para {$user->name}.");
    }
}