<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(Request $request){
       $fields =  $request->validate([
            'name' => 'required|max:250',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = User::create($fields);

        $token =  $user->createToken($request->name);
        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }

    public function login(Request $request){
        $fields =  $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ]);

        //  Auth::attempt(['email'=> $request->email,'password'=>$request->password]);

        $user =  User::where('email',$request->email)->first();
        if (!$user || !Hash::check($request->password,$user->password)) {
            return [
                'message' => "Identifiant invalid"
            ];
        }

        $token =  $user->createToken($user->name);
        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];

    }

    public function logout(Request $request){
        
        $request->user()->tokens()->delete();
        return [
             'message' => "Deconnexion avec success"
        ];
    }

}
