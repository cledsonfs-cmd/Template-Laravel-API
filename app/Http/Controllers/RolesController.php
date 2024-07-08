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
 * @OA\ Post (
 *     path="/api/roles",
 *     tags={"Roles"},
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
 *                  @OA\Property(property="role", type="object",
 *                      @OA\Property(property="id", type="number", example=1),
 *                      @OA\Property(property="name", type="string", example="ROLE_NAME"),
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
  echo "xxx";
  return response()->json([
    'meta' => [
        'code' => 200,
        'status' => 'success',
        'message' => 'Roles fetched successfully!',
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

    //  /**
    //   * Save
    //   * @OA\Post (
    //   *     path="/api/roles",
    //  *     tags={"Roles"},
    // *     @OA\RequestBody(
    //  *         @OA\MediaType(
    //  *             mediaType="application/json",
    //  *             @OA\Schema(
    //  *                 @OA\Property(
    //  *                      type="object",
    //  *                      @OA\Property(
    //  *                          property="nome",
    //  *                          type="string"
    //  *                      ),
    //  *                 example={
    //  *                     "name":"role_nome"
    //  *                }
    //  *             )
    //  *         )
    // *      ),
    //  *      @OA\Response(
    //  *          response=200,
    //  *          description="Success",
    //  *          @OA\JsonContent(
    //  *              @OA\Property(property="meta", type="object",
    //  *                  @OA\Property(property="code", type="number", example=200),
    //  *                  @OA\Property(property="status", type="string", example="success"),
    //  *                  @OA\Property(property="message", type="string", example="Role Added"),
    //  *              ),
    //  *              @OA\Property(property="data", type="object",
    //  *                  @OA\Property(property="nome", type="object",
    //  *                      @OA\Property(property="id", type="number", example=1),
    //  *                      @OA\Property(property="nome", type="string", example="role_nome"),
    //  *                      @OA\Property(property="updated_at", type="string", example="2022-06-28 06:06:17"),
    //  *                      @OA\Property(property="created_at", type="string", example="2022-06-28 06:06:17"),
    //  *                  ),
    //  *                  @OA\Property(property="access_token", type="object",
    //  *                      @OA\Property(property="token", type="string", example="randomtokenasfhajskfhajf398rureuuhfdshk"),
    //  *                      @OA\Property(property="type", type="string", example="Bearer"),
    //  *                      @OA\Property(property="expires_in", type="number", example=3600),
    //  *                  ),
    //  *              ),
    //  *          )
    //  *      ),
    //  *      @OA\Response(
    //  *          response=422,
    //  *          description="Validation error",
    //  *          @OA\JsonContent(
    //  *              @OA\Property(property="meta", type="object",
    //  *                  @OA\Property(property="code", type="number", example=422),
    //  *                  @OA\Property(property="status", type="string", example="error"),
    //  *                  @OA\Property(property="message", type="object",
    //  *                      @OA\Property(property="nome", type="array", collectionFormat="multi",
    //  *                        @OA\Items(
    //  *                          type="string",
    //  *                          example="The nome has already been taken.",
    //  *                          )
    //  *                      ),
    //  *                  ),
    //  *              ),
    //  *              @OA\Property(property="data", type="object", example={}),
    //  *          )
    //  *      )
    //  * )
    //  */
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
