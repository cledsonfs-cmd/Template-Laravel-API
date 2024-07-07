<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;

class StatusController extends Controller
{
  public function __construct(){
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
  public function getAll(){
    $statuss = Status::all();
    return response()->json($statuss);
  }

  public function findId($id){
    $status = Status::find($id);
    if(!empty($status)){
      return response()->json($status);
    }else{
      return response()->json([
        "message" => "Status not found"
      ], 404);
    }
  }


  public function save(Request $request){
    $status = new Status;
    $status->nome = $request->nome;
    $status->save();
    return response()->json([
      "message" => "Status Added"
    ], 201);
  }

  public function update(Request $request, $id){
    if(Status::where('id', $id)->exists()){
      $status = Status::find($id);
      $status->nome = $request->nome;
      $status->updated_at = now();
      $status->save();
      return response()->json([
        "message" => "Status Updated"
      ], 200);
    }else{
      return response()->json([
        "message" => "Status not Found"
      ], 404);
    }
  }

  public function delete($id){
    if(Status::where('id', $id)->exists()){
      $status = Status::find($id);
      $status->delete();
      return response()->json([
        "message" => "Status Deleted"
      ], 200);
    }else{
      return response()->json([
        "message" => "Status not Found"
      ], 404);
    }
  }
}
