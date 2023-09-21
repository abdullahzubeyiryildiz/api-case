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
 *      description="L5 Swagger OpenApi description",
 * )
 */
/**
 * @OA\PathItem(path="/api")
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}



