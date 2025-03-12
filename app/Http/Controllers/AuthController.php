<?php

namespace App\Http\Controllers;

use App\Models\User;
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

        // check if user exists
        $user = User::where('username', $username)
                        ->where('deleted_at', null)
                        ->first();

        if (!$user) {            
            return redirect()
                    ->back()
                    ->withInput()
                    ->with('loginError', 'Username ou Password inválido(s)');
        }

        // check if password is correct
        if (!password_verify($password, $user->password)) {
            return redirect()
                    ->back()
                    ->withInput()
                    ->with('loginError', 'Username ou Password inválido(s)');
        }

        // update last login
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        // set session
        session([
            'user'=> [
                'id' => $user->id,
                'username' => $user->username
            ]
        ]);

        return redirect()->to('/');
    }

    public function register()
    {
        return view("register");
    }

    public function registerSubmit(Request $request)
    {
        // form validation
        $request->validate(
            // validation rules
            [
                'text_username' => 'required|email',
                'text_password' => 'required|min:6|max:16|same:text_confirm_password',
                'text_confirm_password' => 'required|min:6|max:16|same:text_password',
            ],
            // custom validation messages
            [
                'text_username.required' => 'O username é obrigatório',
                'text_username.email' => 'username deve ser um email válido',

                'text_password.required' => 'O password é obrigatório',
                'text_password.min' => 'password deve ter no mínimo :min caracteres',
                'text_password.max' => 'password deve ter no máximo :max caracteres',
                'text_password.same' => 'O password deve coincidir com a confirmação do password',

                'text_confirm_password.required' => 'A confirmação do password é obrigatória',
                'text_confirm_password.min' => 'password deve ter no mínimo :min caracteres',
                'text_confirm_password.max' => 'password deve ter no máximo :max caracteres',
                'text_confirm_password.same' => 'A confirmação do password deve coincidir com o password',
            ]
        );

        // get user input
        $username = $request->get('text_username');
        $password = $request->get('text_password');

        // check if user exists
        $user = User::where('username', $username)
                        ->where('deleted_at', null)
                        ->first();

        if ($user) {            
            return redirect()
                    ->back()
                    ->withInput()
                    ->with('registerError', 'Username já cadastrado');
        }

        // register user
        $user = new User();
        $user->insert([
            'username' => $username,
            'password' => bcrypt($password),
            'created_at' => now()
        ]);

        // redirect to login
        return redirect()->to('/login');
    }
    
    public function logout()
    {
        // logout from the session
        session()->forget('user');
        return redirect()->to('/login');
    }
}
