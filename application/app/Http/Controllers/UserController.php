<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function listar()
    {
        $user = new User();
        $users = $user->get();
        return view('listar-usuarios')->with('users', $users);
    }
    
    public function criar(Request $request)
    {
        $user = new User();

        $view = 'criar-usuario';
        if (!empty($request->get('user_id'))) {
            $user = $user->find($request->get('user_id'));
            $view = 'criar-usuario/' . $request->get('user_id');
        }

        $errors = $this->validarDados($request);
        if($errors) {
            return redirect($view)
                ->with('user', $user)
                ->with('errors', $errors);
        }

        $nome = $request->get('nome');
        $email = $request->get('email');

        if (!empty($request->get('password'))) {
            $password = Hash::make($request->get('password'));
            $user->password = $password;
        }

        $user->name = $nome;
        $user->email = $email;

        $user->save();

        return redirect('/listar-usuarios');

    }

    public function viewEditar($id)
    {
        $user = new User();

        return view('criar-usuario')->with('user', $user->find($id));
    }

    
    public function validarDados($request)
    {
        $errors = [];
        if (empty($request->get('nome'))) {
            array_push($errors,['campo' => 'Nome']);
        }
        
        if (empty($request->get('email'))) {
            array_push($errors,['campo' => 'E-mail']);
        }
        
        return $errors;
    }
}
