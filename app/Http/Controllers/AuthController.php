<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class AuthController extends Controller
{
    public function login()
    {
        return view("login");
    }

    public function loginSubmit(Request $request)
    {
        // form validation
        $request->validate(
            // validation rules
            [
                'text_username' => 'required|email',
                'text_password' => 'required|min:6|max:16',
            ],
            // custom validation messages
            [
                'text_username.required' => 'O username é obrigatório',
                'text_username.email' => 'username deve ser um email válido',
                'text_password.required' => 'O password é obrigatório',
                'text_password.min' => 'password deve ter no mínimo :min caracteres',
                'text_password.max' => 'password deve ter no máximo :max caracteres',
            ]
        );

        // get user input
        $username = $request->get('text_username');
        $password = $request->get('text_password');

        // check if user exists in database
        try{
            DB::connection()->getPdo();
            echo "Connected";
        } catch (\PDOException $e) {
            echo $e;
        }

        dd($request->all());
    }

    public function logout()
    {
        echo "Logout";
    }
}
