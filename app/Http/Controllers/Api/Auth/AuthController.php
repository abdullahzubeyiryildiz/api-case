<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Swagger\Annotations as OA;
class AuthController extends Controller
{

    public function register(Request $request)
    {

        $validator = $this->registervalidate($request);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }


          $user =  User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'username'=>$request->username,
                'password'=>Hash::make($request->password), 
            ]);

        return response()->json(['error'=>false,'message' => __('Başarıyla Kayıt Oluşturuldu')], 201);
    }

}
