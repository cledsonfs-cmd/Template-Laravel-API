<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth:api');
  }

  /**
   * Refresh
   * @OA\Get (
   *     path="/users",
   *     tags={"User"},
   *      @OA\Response(
   *          response=200,
   *          description="Success",
   *          @OA\JsonContent(
   *              @OA\Property(property="meta", type="object",
   *                  @OA\Property(property="code", type="number", example=200),
   *                  @OA\Property(property="status", type="string", example="success"),
   *                  @OA\Property(property="message", type="string", example=null),
   *              ),
   *              @OA\Property(property="data", type="object",
   *                  @OA\Property(property="user", type="object",
   *                      @OA\Property(property="id", type="number", example=1),
   *                      @OA\Property(property="name", type="string", example="John"),
   *                      @OA\Property(property="email", type="string", example="john@test.com"),
   *                      @OA\Property(property="email_verified_at", type="string", example=null),
   *                      @OA\Property(property="updated_at", type="string", example="2022-06-28 06:06:17"),
   *                      @OA\Property(property="created_at", type="string", example="2022-06-28 06:06:17"),
   *                  ),
   *              ),
   *          )
   *      ),
   *      @OA\Response(
   *          response=401,
   *          description="Invalid token",
   *          @OA\JsonContent(
   *              @OA\Property(property="meta", type="object",
   *                  @OA\Property(property="code", type="number", example=422),
   *                  @OA\Property(property="status", type="string", example="error"),
   *                  @OA\Property(property="message", type="string", example="Unauthenticated."),
   *              ),
   *              @OA\Property(property="data", type="object", example={}),
   *          )
   *      ),
   *      security={
   *         {"token": {}}
   *     }
   * )
   */
  public function getAll()
  {
    return response()->json([
      'meta' => [
        'code' => 200,
        'status' => 'success',
        'message' => 'Roles fetched successfully!',
      ],
      'data' => User::all(),
    ]);
  }
}
