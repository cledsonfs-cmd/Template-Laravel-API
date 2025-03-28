<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPUnit\Metadata\Metadata;

class AuthController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth:api', ['except' => ['login', 'register']]);
  }

  /**
   * Register
   * @OA\Post (
   *     path="/api/register",
   *     tags={"Auth"},
   *     @OA\RequestBody(
   *         @OA\MediaType(
   *             mediaType="application/json",
   *             @OA\Schema(
   *                 @OA\Property(
   *                      type="object",
   *                      @OA\Property(
   *                          property="name",
   *                          type="string"
   *                      ),
   *                      @OA\Property(
   *                          property="email",
   *                          type="string"
   *                      ),
   *                      @OA\Property(
   *                          property="password",
   *                          type="string"
   *                      )
   *                 ),
   *                 example={
   *                     "name":"John",
   *                     "email":"john@test.com",
   *                     "password":"johnjohn1"
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
   *      )
   * )
   */
  public function register(Request $request)
  {

    $request->validate([
      'nome' => 'required|string|max:255',
      'email' => 'required|string|email|max:255',
      'password' => 'required|string|min:6',
    ]);

    // $request->validate([
    //   'nome' => 'required|string|max:255',
    //   'email' => 'required|string|email|max:255|unique:users',
    //   'password' => 'required|string|min:6',
    // ]);

    $roles = Role::all()->where('nome', $request->role);
    if ($roles->isEmpty()) {
      $role = Role::create([
        'nome' => $request->role,
      ]);
    } else {
      $role = $roles->first();
    }

    $user = User::create([
      'name' => $request->nome,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'id_role' => $role->id,
      'id_status' => 1
    ]);

    $token = 'bearer ' . Auth::login($user);

    return response()->json([
      'uuid' => $user->id,
      'email' => $user->email,
      'token' => [
        'token' => $token,
      ],
      'provedor' => $user->provedor,
      'imageUrl' => $user->imageUrl,
      'role' => [
        'id' => $role->id,
        'name' => $role->nome
      ]
    ]);
  }

  /**
   * Login
   * @OA\Post (
   *     path="/api/login",
   *     tags={"Auth"},
   *     @OA\RequestBody(
   *         @OA\MediaType(
   *             mediaType="application/json",
   *             @OA\Schema(
   *                 @OA\Property(
   *                      type="object",
   *                      @OA\Property(
   *                          property="email",
   *                          type="string"
   *                      ),
   *                      @OA\Property(
   *                          property="password",
   *                          type="string"
   *                      )
   *                 ),
   *                 example={
   *                     "email":"adm@template.com",
   *                     "password":"adm123456"
   *                }
   *             )
   *         )
   *      ),
   *      @OA\Response(
   *          response=200,
   *          description="Valid credentials",
   *          @OA\JsonContent(
   *              @OA\Property(property="meta", type="object",
   *                  @OA\Property(property="code", type="number", example=200),
   *                  @OA\Property(property="status", type="string", example="success"),
   *                  @OA\Property(property="message", type="string", example=null),
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
   *                  @OA\Property(property="access_token", type="object",
   *                      @OA\Property(property="token", type="string", example="randomtokenasfhajskfhajf398rureuuhfdshk"),
   *                      @OA\Property(property="type", type="string", example="Bearer"),
   *                      @OA\Property(property="expires_in", type="number", example=3600),
   *                  ),
   *              ),
   *          )
   *      ),
   *      @OA\Response(
   *          response=401,
   *          description="Invalid credentials",
   *          @OA\JsonContent(
   *              @OA\Property(property="meta", type="object",
   *                  @OA\Property(property="code", type="number", example=401),
   *                  @OA\Property(property="status", type="string", example="error"),
   *                  @OA\Property(property="message", type="string", example="Incorrect username or password!"),
   *              ),
   *              @OA\Property(property="data", type="object", example={}),
   *          )
   *      )
   * )
   */
  public function login(Request $request)
  {
    $request->validate([
      'username' => 'required|string|email',
      'password' => 'required|string',
    ]);

    $credentials = $request->only('username', 'password');


    $login = [
      'email' =>  $credentials['username'],
      'password' => $credentials['password'],
    ];


    $token = Auth::attempt($login);
    if (!$token) {
      return response()->json([
        'status' => 'error',
        'message' => 'Unauthorized',
      ], 401);
    }

    $user = Auth::user();

    $role = Role::all()->find($user->id_role);

    return response()->json([
      'uuid' => $user->id,
      'email' => $user->email,
      'token' => [
        'token' => $token,
      ],
      'provedor' => $user->provedor,
      'imageUrl' => $user->imageUrl,
      'role' => [
        'id' => $role->id,
        'name' => $role->nome
      ]
    ]);
  }

  /**
   * Logout
   * @OA\Post (
   *     path="/api/logout",
   *     tags={"Auth"},
   *      @OA\Response(
   *          response=200,
   *          description="Success",
   *          @OA\JsonContent(
   *              @OA\Property(property="meta", type="object",
   *                  @OA\Property(property="code", type="number", example=200),
   *                  @OA\Property(property="status", type="string", example="success"),
   *                  @OA\Property(property="message", type="string", example="Successfully logged out"),
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
  public function logout()
  {
    // get token
    $token = JWTAuth::getToken();

    // invalidate token
    $invalidate = JWTAuth::invalidate($token);

    if ($invalidate) {
      return response()->json([
        'Logout efetuado com sucesso!',
      ]);
    }
  }

  /**
   * Refresh
   * @OA\Post (
   *     path="/api/refresh",
   *     tags={"Auth"},
   *      @OA\Response(
   *          response=200,
   *          description="Success",
   *          @OA\JsonContent(
   *              @OA\Property(property="meta", type="object",
   *                  @OA\Property(property="code", type="number", example=200),
   *                  @OA\Property(property="status", type="string", example="success"),
   *                  @OA\Property(property="message", type="string", example="Successfully logged out"),
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
  public function refresh()
  {
    $user = Auth::user();

    $role = Role::all()->find($user->id_role);

    return response()->json([
      'uuid' => $user->id,
      'email' => $user->email,
      'token' => [
        'token' => Auth::refresh(),
      ],
      'provedor' => $user->provedor,
      'imageUrl' => $user->imageUrl,
      'role' => [
        'id' => $role->id,
        'name' => $role->nome
      ]
    ]);
  }


  /**
   * Users
   * @OA\Get (
   *     path="/api/users",
   *     tags={"Auth"},
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
    $users = User::all();

    $data = collect();

    foreach ($users as $user) {
      $role = Role::all()->find($user->id_role);
      $data->push(
        [
          'uuid' => $user->id,
          'email' => $user->email,
          'provedor' => $user->provedor,
          'imageUrl' => $user->imageUrl,
          'role' => [
            'id' => $role->id,
            'name' => $role->nome
          ]
        ]
      );
    }

    return response()->json($data);
  }
}
