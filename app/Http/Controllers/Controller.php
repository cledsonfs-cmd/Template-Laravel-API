<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *    title="Api Laravel - Template Base",
 *    description="Templeta basico para desenvolvimento de APIs em Laravel.",
 *    version="1.0.0",
 * ),
 * @OA\SecurityScheme(
 *     type="apiKey",
 *     in="header",
 *     securityScheme="token",
 *     name="Authorization"
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs,ValidatesRequests;
}
