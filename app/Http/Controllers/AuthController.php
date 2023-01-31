<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(Request $request){

        $user = User::where('email', $request->email)->first();
        if($user){
            return response()->json([
                'message' => 'Email already exists'
            ], Response::HTTP_NOT_FOUND);
        }
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }


    public function login(Request $request){

        $fields = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6'
        ]);

        // Validate email
        $user = User::where('email', $fields['email'])->first();

        // Validate password
        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response(
                [
                    'message'=> 'Wrong credentials',
                    'status' => '401'
                ]
            , 401);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged out',
            'status' => Response::HTTP_OK
        ]; 
    }
}
