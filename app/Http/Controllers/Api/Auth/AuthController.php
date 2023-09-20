<?php

namespace App\Http\Controllers\Api\Auth;


use HttpResponses;
use Illuminate\Http\Request;

use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        $user = $this->userService->register($request->all());

        if ($user) {
            return api_response(__('Registration Created Successfully.'), HttpResponses::HTTP_OK, ['user' => $user]);
        }

        return api_response(__('Something went wrong.'), HttpResponses::HTTP_UNAUTHORIZED);
    }


    public function login(Request $request)
    {
        $user = $this->userService->login($request->all());

        if ($user) {
            $token = $user->createToken('api_case')->accessToken;
            return api_response(__('Success Login'), HttpResponses::HTTP_OK, ['token' => $token,'user' => $user]);
        }

        return api_response(__('Information is Incorrect'), HttpResponses::HTTP_UNAUTHORIZED);
    }


    public function myProfile(Request $request){
        $user = $this->userService->user();

        return api_response(__('My Profile'), HttpResponses::HTTP_OK, ['user' => new UserResource($user)]);
    }


    public function updateUserImage(Request $request)
    {

         $user =  $this->userService->updateUserImage(auth()->user()->id, $request->file('image'));

        if ($user) {
            return api_response(__('Updated Image'), HttpResponses::HTTP_OK, ['user' => new UserResource($user)]);
        }

        return api_response(__('Information is Incorrect'), HttpResponses::HTTP_UNAUTHORIZED);
    }
}
