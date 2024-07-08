<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;

class StatusController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:api');
  }

  /**
   * Get All
   * @OA\Get (
   *     path="/api/status",
   *     tags={"Status"},
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
   *                  @OA\Property(property="status", type="object",
   *                      @OA\Property(property="id", type="number", example=1),
   *                      @OA\Property(property="name", type="string", example="STATUS_NAME"),
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
      'data' => [
        Status::all(),
      ],
    ]);
  }

  /**
   * Get Id
   * @OA\Get (
   *     path="/api/status/{id}",
   *     tags={"Status"},
   *     @OA\Parameter(
   *      description="ID",
   *      in="path",
   *      name="id",
   *      required=true,
   *      example="1",
   *      @OA\Schema(
   *        type="integer",
   *        format="int64"
   *      )
   *     ), 
   *      @OA\Response(
   *          response=200,
   *          description="Success",
   *          @OA\JsonContent(
   *              @OA\Property(property="meta", type="object",
   *                  @OA\Property(property="code", type="number", example=200),
   *                  @OA\Property(property="status", type="string", example="success"),
   *                  @OA\Property(property="message", type="string", example="Status fetched successfully!"),
   *              ),
   *              @OA\Property(property="data", type="object",
   *                  @OA\Property(property="status", type="object",
   *                      @OA\Property(property="id", type="number", example=1),
   *                      @OA\Property(property="name", type="string", example="STATUS_NAME"),
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
  public function findId($id)
  {
    $status = Status::find($id);
    if (!empty($status)) {
      return response()->json([
        'meta' => [
          'code' => 200,
          'status' => 'success',
          'message' => 'Role fetched successfully!',
        ],
        'data' => [
          $status,
        ],
      ]);
    } else {
      return response()->json([
        'meta' => [
          'code' => 404,
          'status' => 'success',
          'message' => 'Status not found!',
        ],
      ]);
    }
  }

  /**
   * Save
   * @OA\Post (
   *     path="/api/status",
   *     tags={"Status"},
   *     @OA\RequestBody(
   *         @OA\MediaType(
   *             mediaType="application/json",
   *             @OA\Schema(
   *                 @OA\Property(
   *                      type="object",
   *                      @OA\Property(
   *                          property="nome",
   *                          type="string"
   *                      ),
   *                 ),
   *                 example={
   *                     "nome":"STATUS_NOME",
   *                }
   *             )
   *         )
   *      ),
   *      @OA\Response(
   *          response=200,
   *          description="Success",
   *          @OA\JsonContent(
   *              @OA\Property(property="meta", type="object",
   *                  @OA\Property(property="code", type="number", example=200),
   *                  @OA\Property(property="status", type="string", example="success"),
   *                  @OA\Property(property="message", type="string", example="Status saved!"),
   *              ),
   *              @OA\Property(property="data", type="object",
   *                  @OA\Property(property="user", type="object",
   *                      @OA\Property(property="id", type="number", example=1),
   *                      @OA\Property(property="nome", type="string", example="STATUS_NOME"),
   *                      @OA\Property(property="updated_at", type="string", example="2022-06-28 06:06:17"),
   *                      @OA\Property(property="created_at", type="string", example="2022-06-28 06:06:17"),
   *                  ),
   *                  @OA\Property(property="access_token", type="object",
   *                      @OA\Property(property="token", type="string", example="randomtokenasfhajskfhajf398rureuuhfdshk"),
   *                      @OA\Property(property="type", type="string", example="Bearer"),
   *                      @OA\Property(property="expires_in", type="number", example=3600),
   *                  ),
   *              ),
   *          )
   *      ),
   *      @OA\Response(
   *          response=422,
   *          description="Validation error",
   *          @OA\JsonContent(
   *              @OA\Property(property="meta", type="object",
   *                  @OA\Property(property="code", type="number", example=422),
   *                  @OA\Property(property="status", type="string", example="error"),
   *                  @OA\Property(property="message", type="object",
   *                      @OA\Property(property="email", type="array", collectionFormat="multi",
   *                        @OA\Items(
   *                          type="string",
   *                          example="The email has already been taken.",
   *                          )
   *                      ),
   *                  ),
   *              ),
   *              @OA\Property(property="data", type="object", example={}),
   *          )
   *      ),
   *      security={
   *         {"token": {}}
   *     }
   * )
   */
  public function save(Request $request)
  {
    $status = new Status;
    $status->nome = $request->nome;
    $status->save();
    return response()->json([
      "message" => "Status Added"
    ], 201);
  }

  /**
   * Update
   * @OA\Put (
   *     path="/api/status/{id}",
   *     tags={"Status"},
   *     @OA\Parameter(
   *      description="ID",
   *      in="path",
   *      name="id",
   *      required=true,
   *      example="1",
   *      @OA\Schema(
   *        type="integer",
   *        format="int64"
   *      )
   *     ),
   *     @OA\RequestBody(
   *         @OA\MediaType(
   *             mediaType="application/json",
   *             @OA\Schema(
   *                 @OA\Property(
   *                      type="object",
   *                      @OA\Property(
   *                          property="nome",
   *                          type="string"
   *                      ),
   *                 ),
   *                 example={
   *                     "nome":"STATUS_NOME",
   *                }
   *             )
   *         )
   *      ),
   *     @OA\Response(
   *          response=200,
   *          description="Success",
   *          @OA\JsonContent(
   *              @OA\Property(property="meta", type="object",
   *                  @OA\Property(property="code", type="number", example=200),
   *                  @OA\Property(property="status", type="string", example="success"),
   *                  @OA\Property(property="message", type="string", example="Status updated successfully!"),
   *              ),
   *              @OA\Property(property="data", type="object",
   *                  @OA\Property(property="status", type="object",
   *                      @OA\Property(property="id", type="number", example=1),
   *                      @OA\Property(property="name", type="string", example="STATUS_NAME"),
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
  public function update(Request $request, $id)
  {
    if (Status::where('id', $id)->exists()) {
      $status = Status::find($id);
      $status->nome = $request->nome;
      $status->updated_at = now();
      $status->save();
      return response()->json([
        "message" => "Status Updated"
      ], 200);
    } else {
      return response()->json([
        "message" => "Status not Found"
      ], 404);
    }
  }

  /**
   * Get Id
   * @OA\Delete (
   *     path="/api/status/{id}",
   *     tags={"Status"},
   *     @OA\Parameter(
   *      description="ID",
   *      in="path",
   *      name="id",
   *      required=true,
   *      example="1",
   *      @OA\Schema(
   *        type="integer",
   *        format="int64"
   *      )
   *     ), 
   *      @OA\Response(
   *          response=200,
   *          description="Success",
   *          @OA\JsonContent(
   *              @OA\Property(property="meta", type="object",
   *                  @OA\Property(property="code", type="number", example=200),
   *                  @OA\Property(property="status", type="string", example="success"),
   *                  @OA\Property(property="message", type="string", example="Status deleted successfully!"),
   *              ),
   *              @OA\Property(property="data", type="object", example={}),   
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
  public function delete($id)
  {
    if (Status::where('id', $id)->exists()) {
      $status = Status::find($id);
      $status->delete();
      return response()->json([
        "message" => "Status Deleted"
      ], 200);
    } else {
      return response()->json([
        "message" => "Status not Found"
      ], 404);
    }
  }
}
