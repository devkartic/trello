<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function register(Request $request){

        $user = User::create([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'api_token' => Str::random(50),
            'password' => Hash::make($request->input('password'))
        ]);

        return response()->json(['user' => $user], 200);
    }

    public function login(Request $request){

        $user = User::where('email', $request->input('email'))
            ->first();


        if(!$user){
            return response()->json(['status' => 'error', 'message' => 'User not found!'], 401);
        }


        if(Hash::check($request->input('password'), $user->password)){

            $user->update(['api_token' => Str::random(50)]);

            return response()->json(['status' => 'success', 'message' => 'Logged in Successfully.'], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'Credential Invalid!'], 401);
    }




    public function logout(Request $request){
        $api_token = $request->input('api_token');

        $user = User::where('api_token', $api_token)->first();

        if(!$user){
            return response()->json(['status' => 'error', 'message' => 'Not Logged In !'], 401);
        }
        $user->api_token = null;
        $user->save();

        return response()->json(['status' => 'success', 'message' => 'Log out Successfully.'], 200);
    }
}
