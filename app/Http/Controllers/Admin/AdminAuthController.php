<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins', ['except' => ['login', 'resetPassword']]);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = auth()->guard('admins')->attempt($credentials)) {
                return response()->json(['error' => 'Incorrect email or password'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        $admin = auth()->guard('admins')->user();
        return response()->json([
            'success' => 'Admin logged in successfully',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('admins')->factory()->getTTL() * 7200,
            'data' => $admin,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ]);
        $admin = Admin::where('email', $request->email)->first();
        if ($admin) {
            $password = $admin->name . rand(1000, 9999);
            $admin->password = bcrypt($password);
            $admin->save();
            $maildata = array(
                'name' => $admin->name,
                'username' => $admin->email,
                'password' => $password
            );
            Mail::to($admin->email)->send(new ResetPasswordMail($maildata));
            return response()->json(array('msg' => 'success', 'response' => 'Password reset email sent successfully!'));
        } else {
            return response()->json(array('msg' => 'error', 'response' => 'Email not found'), 422);
        }
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('admins')->refresh());
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
    public function me()
    {
        $admin = auth()->guard('admins')->user();
        return response()->json($admin);
    }
    public function logout()
    {
        auth()->guard('admins')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
