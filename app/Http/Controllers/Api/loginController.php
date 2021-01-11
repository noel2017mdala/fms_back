<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;

class loginController extends Controller
{
   public function register(Request $request){
    $validate = $request->validate([
        'first_name' => 'required|min:3',
        'last_name' => 'required|min:3',
        'email'     => 'required|email|unique:users',
        'password' => 'required|min:6'

    ]);

    if($validate){
        
        
        $createUser =  User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        
        

        if($createUser){
            return response()->json(['response' => 'User created successfully'], 201)
                    ->header('Content-Type', 'application/json');
        }else{

            return response()->json(['response' => 'failed to create user'], 500)
            ->header('Content-Type', 'application/json');
        }
    }else{

        return response()->json(['response' => 'failed to create user'], 500)
        ->header('Content-Type', 'application/json');
    }
   }

   public function login(Request $request){

    $validate = $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

        if($validate){
            
            $userData = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            if(auth()->attempt($userData)){
                $user =  $request->user();
                $createToken = $user->createToken('user_auth_token')->accessToken;

                return response()->json([
                    'state' => 1,
                    'user' => 'Bearer',
                    'token' => $createToken,
                    'msg' => 'access token',
                ], 200);
            }else{
                return response()->json([
                    'state' => 0,
                    'msg' => 'Incorrect username or password',
                ], 401);
            }

        }else{
            return 'user not found';
        }

     }
}
