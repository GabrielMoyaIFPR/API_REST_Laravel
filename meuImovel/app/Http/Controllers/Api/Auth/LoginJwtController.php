<?php

namespace App\Http\Controllers\Api\Auth;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class LoginJwtController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->all('email', 'password');

        Validator::make($credentials, [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ])->validate();
        

        if (!$token = auth('api')->attempt($credentials)) {
            $message = new ApiMessages('Unauthorized');
            return response()->json($message->getMessage(), 401);
        }
        
        return response()->json([
            'acess_token' => $token,
        ]);
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Logout com Sucesso!'], 200);
    }

    public function refresh()
    {
        $token = auth('api')->refresh();
        return response()->json([
            'acess_token' => $token,
        ]);
    }
}