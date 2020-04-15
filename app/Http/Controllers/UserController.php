<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;

class UserController extends Controller{

    public function generateJWT(User $user){
        $payload = [
            'id' => $user->id,
            'email' => $user->email
        ];

        return JWT::encode($payload, env('JWT_SECRET'));
    }

    public function login(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');

        $res = Array();

        $user = User::where('email', '=', $email)->first();
        if($user){
            if($user->password == $password){
                $res["staus"] = true;
                $res["token"] = $this->generateJWT($user);
            }
            else{
                $res["staus"] = false;
                $res["reason"] = "password";
            }
        }
        else{
            $res["staus"] = false;
            $res["reason"] = "email";
        }

        return response()->json($res);
    }

    public function register(Request $request){
        $email = $request->input('email');

        $res = Array();

        $user = User::where('email', '=', $email)->first();

        if($user){
            $res["status"] = false;
        }
        else{
            $userCreateResult = User::create($request->all());
            if($userCreateResult){
                $res["status"] = true;
                $res["token"] = $this->generateJWT($user);
            }
            else{
                $res["status"] = false;
            }
        }

        return response()->json($res);
    }
}

?>