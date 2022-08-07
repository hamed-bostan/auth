<?php

namespace App\Http\Controllers;

use App\Mail\ActiveUser;
use App\Mail\UserSignup;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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


            Mail::to($user->email)->send(new UserSignup($user));


            return response()->json([
                'message'=>'registering was successful hamed'
            ],201);
        }
    }




    public function signupActive($token)
    {

        $user= User::where('activation_token',$token)->first();

        // If user activation token does not exist
        if(! $user)
        {
            return response()->json([
               'message'=>'Activation token is invalid'
            ],404);
        }

        // If user activation token does exist
        else
        {
            $user->active=true;
            $user->email_verified_at=Carbon::now();
            $user->activation_token="";

            $user->save();

            Mail::to($user->email)->send(new ActiveUser($user));

            return response()->json([
                'message'=>'User is active now.'
            ],200);
        }
    }
}
