<?php

namespace App\Http\Controllers\Api\Auth;


use HttpResponses;
use Illuminate\Http\Request;

use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
/**
 * @OA\Post(
 *     path="/api/auth/register",
 *     tags={"Auth"},
 *     summary="User registration",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="name",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="phone",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="password",
 *                     type="string"
 *                 ),
 *                 example={"name": "John Doe", "email": "john@example.com", "phone": "123456789", "password": "secret"}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Registration Created Successfully.",
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *     )
 * )
 */
    public function register(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return apiResponse(__('Validation error'), HttpResponses::HTTP_BAD_REQUEST, ['errors' => $validator->errors()]);
        }

        $user = $this->userService->register($data);

        if ($user) {
            return apiResponse(__('Registration Created Successfully.'), HttpResponses::HTTP_OK, ['user' => $user]);
        }

    }


  /**
 * @OA\Post(
 *     path="/api/auth/login",
 *     tags={"Auth"},
 *     summary="User login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="email",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="password",
 *                     type="string"
 *                 ),
 *                 example={"email": "john@example.com", "password": "secret"}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Login successful",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Success Login"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="token", type="string", example="your_access_token"),
 *                 @OA\Property(property="user", type="object")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Information is Incorrect")
 *         )
 *     )
 * )
 */
    public function login(Request $request)
    {
        $user = $this->userService->login($request->all());

        if ($user) {
            $token = $user->createToken('api_case')->accessToken;
            return apiResponse(__('Success Login'), HttpResponses::HTTP_OK, ['token' => $token,'user' => $user]);
        }

        return apiResponse(__('Information is Incorrect'), HttpResponses::HTTP_UNAUTHORIZED);
    }

/**
 * @OA\Get(
 *     path="/api/user/my-profile",
 *     tags={"My Profile"},
 *     summary="Get user profile",
 *     security={{ "bearerAuth": {} }},
 *     @OA\Parameter(
 *         name="Authorization",
 *         in="header",
 *         required=true,
 *         description="Bearer Token",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User profile retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="My Profile"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="user")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthenticated")
 *         )
 *     )
 * )
 */

    public function myProfile(){
        $user = $this->userService->user();

        return apiResponse(__('My Profile'), HttpResponses::HTTP_OK, ['user' => new UserResource($user)]);
    }


    /**
 * @OA\Post(
 *     path="/api/user/update/image",
 *     tags={"My Profile"},
 *     summary="Update user profile image",
 *     security={{ "bearerAuth": {} }},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="image",
 *                     type="string",
 *                     format="binary"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User profile image updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Updated Image"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="user" )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthenticated")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The given data was invalid.")
 *         )
 *     )
 * )
 */
    public function updateUserImage(Request $request)
    {
         $user =  $this->userService->updateUserImage(auth()->user()->id, $request->file('image'));

        if ($user) {
            return apiResponse(__('Updated Image'), HttpResponses::HTTP_OK, ['user' => new UserResource($user)]);
        }

        return apiResponse(__('Information is Incorrect'), HttpResponses::HTTP_UNAUTHORIZED);
    }
}
