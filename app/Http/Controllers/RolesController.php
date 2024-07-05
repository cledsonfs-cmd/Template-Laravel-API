<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RolesController extends Controller
{
    public function __construct(){
      $this->middleware('auth:api');
    }

  /**
 * Get All
 * @OA\Get (
 *     path="/api/roles",
 *     tags={"Roles"},
 *      @OA\Response(
 *          response=200,
 *          description="Success",
 *          @OA\JsonContent(
 *              @OA\Property(property="meta", type="object",
 *                  @OA\Property(property="code", type="number", example=200),
 *                  @OA\Property(property="status", type="string", example="success"),
 *                  @OA\Property(property="message", type="string", example="User fetched successfully!"),
 *              ),
 *              @OA\Property(property="data", type="object", 
 *                  @OA\Property(property="user", type="object",
 *                      @OA\Property(property="id", type="number", example=2),
 *                      @OA\Property(property="name", type="string", example="User"),
 *                      @OA\Property(property="email", type="string", example="user@test.com"),
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
public function getAll(){
  return response()->json([
    'meta' => [
        'code' => 200,
        'status' => 'success',
        'message' => 'User fetched successfully!',
    ],
    'data' => [
      Role::all(),
    ],
]);
}

    public function findId($id){
      // $role = Role::find($id);
      // if(!empty($role)){
      //   return response()->json($role);
      // }else{
      //   return response()->json([
      //     "message" => "Role not found"
      //   ], 404);
      // }
      return response()->json([
        'meta' => [
            'code' => 200,
            'status' => 'success',
            'message' => 'User fetched successfully!',
        ],
        'data' => [
          Role::find($id),
        ],
    ]);
    }

    public function save(Request $request){
      $role = new Role;
      $role->nome = $request->nome;
      $role->save();
      return response()->json([
        "message" => "Role Added"
      ], 201);
    }

    public function update(Request $request, $id){
      if(Role::where('id', $id)->exists()){
        $role = Role::find($id);
        $role->nome = $request->nome;
        $role->updated_at = now();
        $role->save();
        return response()->json([
          "message" => "Role Updated"
        ], 200);
      }else{
        return response()->json([
          "message" => "Role not Found"
        ], 404);
      }
    }

    public function delete($id){
      if(Role::where('id', $id)->exists()){
        $role = Role::find($id);       
        $role->delete();
        return response()->json([
          "message" => "Role Deleted"
        ], 200);
      }else{
        return response()->json([
          "message" => "Role not Found"
        ], 404);
      }
    }
    
}
