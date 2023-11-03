<?php

namespace App\Http\Controllers\User;

use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;


class UserAuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'phone' => 'required|numeric|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
            'c_password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(array('msg' => 'error', 'response' => $validator->errors()));
        }
        // dd($request->all());
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['alert_email_1'] = $input['email'];
        $input['account_no'] = rand(100000, 999999);
        $input['username'] = $input['email'];
        $user = User::create($input);
        $user = User::find($user->id);

        // I'll implement email verification using this resource on github:
        https: //github.com/lucenarenato/laravel-jwt-authentication-api-email-verification/blob/master/app/Http/Controllers/AuthController.php
        return response()->json(array('msg' => 'success', 'response' => 'User registered successfully', 'data' => $user));
    }

    public function login()
    {
        $credentials = request(['email', 'password']);
        try {
            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Incorrect email or password'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(array('msg' => 'error', 'response' => 'Something went wrong. Please try again.'));
        }
        $user = Auth::user();
        return response()->json(array('msg' => 'success', 'response' => 'Logged in successfully', 'access_token' => $token, 'token_type' => 'bearer', 'data' => $user, 'expires_in' => auth()->factory()->getTTL() * 7200));
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
