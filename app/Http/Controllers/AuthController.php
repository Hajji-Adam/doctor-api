<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(Request $request)
        {
            $fields = $request->validate([
                'name' => 'required|max: 255',
                'email' => 'required| email | unique:users',
                'password' => 'required|confirmed'
                ]);
                $user = User::create($fields);

                $token = $user->createToken ($request->name);
               
                return [
                    'user' => $user,
                    'token' => $token->plainTextToken
                    ];


        }
    public function login(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'password' => 'required|string'
    ]);

    // Retrieve the user by email
    $user = User::where('email', $request->email)->first();

    // Check if the user exists and the password is correct
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'errors' => [
                'email' => ['The provided credentials are incorrect.']
            ]
        ], 401); // Return a 401 Unauthorized status
    }

    // Create a token for the user
    $token = $user->createToken($user->name)->plainTextToken;

    // Return the user and token
    return response()->json([
        'user' => $user,
        'token' => $token
    ], 200); // Return a 200 OK status
}
        
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'You are logged out.' 
        ];
    }
}
