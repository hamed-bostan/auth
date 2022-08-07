<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // my way for validating
//        $validate= $this->validate($request,[
//           'first_name'=>'required|str|min:3',
//           'last_name'=>'required|str|min:3',
//           'email'=>'required|unique',
//           'password'=>'required|confirmed|min:3'
//        ]);


        $validate=Validator::make($request->all(),[
            'first_name'=>['required','string'],
            'last_name'=>['required','string'],
            'email'=>['required','email','max:255','unique:users'],
            'password'=>['required','confirmed','min:8'],
        ]);


        // if validator has failed.
        if ($validate->fails())
        {
            return response()->json([
                'message'=>$validate->errors()->first()
            ],400);
        }

        else
        {
            $user=new User([
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
                'activation_token'=>Str::random(60),
                'register_ip'=>$request->ip()
            ]);

            $user->save();

            return response()->json([
                'message'=>'registering was successful hamed'
            ],201);

        }

    }
}
