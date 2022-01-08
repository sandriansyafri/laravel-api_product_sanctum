<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function validationRegister()
    {
        return request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);
    }
    public function validationLogin()
    {
        return request()->validate([
            'email' => 'required|string|email',
            'password' => 'required|confirmed|min:6',
        ]);
    }


    public function register(Request $request)
    {
        $this->validationRegister();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'data' => compact(['user', 'token']),
            'ok' => true,
            'message' => 'ok',
            'status' => Response::HTTP_OK,
        ]);
    }

    public function login(Request $request)
    {
        $this->validationLogin();

        $credential = request()->only('email', 'password');
        if (Auth::attempt($credential)) {
            $user = auth()->user();
            $token = auth()->user()->createToken('token')->plainTextToken;
            return response()->json([
                'data' => compact(['user', 'token']),
                'ok' => true,
                'status' => 'success',
            ]);
        }

        return response()->json([
            'ok' => false,
            'message' => 'error',
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'ok' => true,
            'message' => 'ok',
            'status' => Response::HTTP_OK,
        ]);
    }
}
