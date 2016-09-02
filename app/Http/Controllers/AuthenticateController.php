<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;

class AuthenticateController extends Controller
{
    public function __construct()
    {
      //this middleware will validate for the presence of the JWT - include on all secure routes
      $this->middleware('jwt.auth', ['except' => ['authenticate', 'signup']]);

    }

    //this is used for testing the authentication API until routes are complete
    public function index()
    {
      $users = User::all();
      return $users;
    }

    public function signup(Request $request)
    {
      $userData = $request->only(['name', 'email', 'password']);
      $validator = Validator::make($userData, [
          'name' => 'required|max:255',
          'email' => 'required|email|max:255|unique:users',
          'password' => 'required|min:6',
      ]);

      $userData['password'] = bcrypt($userData['password']);
      if ($validator->fails()){
        $errors = $validator->errors()->all();
          return response()->json(compact('errors'), 401);
      }

      $user = User::create($userData);
      if(!$user->id) {
       return $this->response->error('could_not_create_user', 401);
      }
      $message = 'success';
      $user = $user;
      return response()->json(compact('message', 'user'));
    }


    public function authenticate(Request $request)
    {
      $credentials = $request->only('email', 'password');

      try {
        if (!$token = JWTAuth::attempt($credentials)) {
          return response() -> json(['error'=>'invalid_credentials'], 401);
        }
      } catch (JWTException $e) {
        return response() -> json(['error'=> 'could_not_create_token'], 500);
      }

      //successful authentication provides the token and user info (no password :D )
      $user = User::where('email', $request->email)
        ->get();

      return response()->json(compact('token', 'user'));
    }
}
