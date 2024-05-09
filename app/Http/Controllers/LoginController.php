<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return redirect('/login');
    }


    public function apiLogin(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'password'=>'required'
        ]);

        if (Auth::attempt($validatedData)) {
           
            $user = Auth::user();
            $accessToken = $user->createToken('authToken')->plainTextToken;
    
            return response()->json(['user' => $user, 'access_token' => $accessToken]);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}
