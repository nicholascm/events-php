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


    public function index()
    {
      $users = User::all();
      return $users;
    }
    //this one works
    public function signup(Request $request)
    {
      $userData = $request->only(['name', 'email', 'password']);
      $validator = Validator::make($userData, [
          'name' => 'required|max:255',
          'email' => 'required|email|max:255|unique:users',
          'password' => 'required|min:6|confirmed',
      ]);
      //necessary?
      $userData['password'] = bcrypt($userData['password']);
      //if ($validator->fails()){
        //throw new ValidationHttpException($validator->errors()->all());
        //}

      $user = User::create($userData);
      if(!$user->id) {
       return $this->response->error('could_not_create_user', 500);
      }

      return "success";

    }
    /*
    public function sign(Request $request)
    {
      $credentials = Input::only('email', 'password');
      try {
          $user = User::create($credentials);
      } catch (Exception $e) {
          return Response::json(['error' => 'User already exists.'], HttpResponse::HTTP_CONFLICT);
      }
      $token = JWTAuth::fromUser($user);
      return Response::json(compact('token'));
    } */

    /*
    public function signIn(Request $request)
    {
      $credentials = Input::only('email', 'password');
      if (!$token = JWTAuth::attempt($credentials)) {
        return Response::json(false, HttpResponse::HTTP_UNAUTHORIZED);
    }
      return Response::json(compact('token'));
    }
    */


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
      return response()->json(compact('token'));
    }
}
