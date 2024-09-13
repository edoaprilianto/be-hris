<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{
    public function login(Request $request)
    {

        // $request->validate([
        //     'email' => 'required|email',
        //     'password' => 'required',
        // ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('Personal Access Token')->accessToken;

            return response()->json([
                'access_token' => $token,
                'user' => $user
            ]);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }
    
    public function logout(Request $request)
    {
        $user = Auth::user();

        // Revoke the token that was used to authenticate the current request
        $user->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
}
