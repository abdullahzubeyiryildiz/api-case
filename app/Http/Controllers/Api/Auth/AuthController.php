<?php

namespace App\Http\Controllers\Api\Auth;

use ImageUpload;
use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request)
    {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|string',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                $response = ['error' => true, 'message' => $validator->errors()];
                return api_response(__('Something went wrong.'), 400, $response);
            }

            User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'password'=>Hash::make($request->password),
            ]);

            return api_response(__('Registration Created Successfully.'), 200);
    }


    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('api_case')->accessToken;

            return api_response(__('Success Login'), 200, ['token' => $token]);
        }

        return api_response(__('Information is Incorrect'), 400);
    }


    public function myProfile(Request $request){
        $user = Auth::user();
        return api_response(__('My Profile'), 200, ['user' => new UserResource($user)]);
    }

    public function changeFoto(Request $request){

        $user = User::find(auth()->user()->id);

        if($request->hasFile('image')) {
            dosyasil($user->image);
            $image = $request->file('image');
            $dosyadi = 'profile_'.time();
            $yukleKlasor = 'img/user/';
            $resimurl = resimyukle($image,$dosyadi,$yukleKlasor);
            $user->image = $resimurl;
            $user->save();
        }

        return api_response(__('Change Foto'), 200, ['user' => new UserResource($user)]);
    }
}
