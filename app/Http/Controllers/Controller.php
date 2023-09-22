<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use OpenApi\Attributes as OA;



   /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Api Case Documentation",
     *      description="Implementation of Swagger with in Laravel",
     *      @OA\Contact(
     *          email="pratikyazilimci@gmail.com"
     *      ),
     * )
     * @OA\PathItem(path="/api")

     *
     *
     */


/**
 * @OA\SecurityScheme(
 *     type="apiKey",
 *     in="header",
 *     name="Authorization",
 *     description="Bearer Token",
 *     securityScheme="bearerAuth",
 *     bearerFormat="JWT",
 * )
 */


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}



