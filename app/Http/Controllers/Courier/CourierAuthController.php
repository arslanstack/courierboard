<?php

namespace App\Http\Controllers\Courier;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Courier;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CompanyWelcomeMail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CourierAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:couriers', ['except' => ['login', 'register', 'resetPassword']]);
    }
    public function register(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address1' => 'required|string|max:255',
            'address2' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zip' => 'required|string|max:255',
            'website' => 'required|string|max:255',
            'drivers' => 'required|numeric',
            'mc_number' => 'required|numeric|digits_between:5,9',
            'dot_number' => 'required|numeric|digits_between:5,9',
            'insurance_name' => 'required|string|max:255',
            'gen_insurance' => 'required|numeric',
            'cargo_insurance' => 'required|numeric',
            'other_insurance' => 'required|numeric',
            'contact_fname' => 'required|string|max:255',
            'contact_lname' => 'required|string|max:255',
            'contact_title' => 'required|string|max:255',
            'company_phone' => 'required|string|max:255',

            'mobile' => 'required|string|unique:couriers|max:20',
            'email' => 'required|string|email|max:255|unique:couriers',
            'password' => 'required|string|min:8|confirmed',

        ]);
        $validator->setCustomMessages([
            'unique' => 'The :attribute is already registered with another courier company.',
        ]);

        if ($validator->fails()) {
            if ($validator->errors()->has('email')) {
                return response()->json(['error' => 'Email address is already registered with another courier company.'], 422);
            }
            return response()->json(['error' => $validator->errors()], 422);
        }
        // dd($request->all());
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['username'] = $input['email'];
        $input['status'] = 0; //inactive before they enter their payment information

        if ($request->has('declaration')) {
            $declaration = $request->file('declaration');
            $declaration_name = time() . '.' . $declaration->getClientOriginalExtension();
            $declaration->move(public_path('uploads/insurance'), $declaration_name);
            $input['declaration'] = $declaration_name;
        } else {
            $input['declaration'] = null;
        }

        $courier = Courier::create($input);
        
        $courier = Courier::find($courier->id);

        $maildata = array(
            'name' => $input['contact_fname'] . ' ' . $input['contact_lname'],
            'company' => $input['name'],
            'username' => $input['email'],
            'password' => $request->password,
        );

        Mail::to($input['email'])->send(new CompanyWelcomeMail($maildata));
        $token = JWTAuth::fromUser($courier);
        return response()->json([
            'success' => 'Courier company registered successfully.',
            'data' => $courier,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 7200,
        ], 200);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = auth()->guard('couriers')->attempt($credentials)) {
                return response()->json(['error' => 'Incorrect email or password'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        $courier = auth()->guard('couriers')->user();
        return response()->json([
            'success' => 'Courier company logged in successfully.',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('couriers')->factory()->getTTL() * 7200,
            'data' => $courier,
        ]);
    }
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ]);
        $courier = Courier::where('email', $request->email)->first();
        if ($courier) {
            $password = $courier->contact_fname . rand(1000, 9999);
            $courier->password = bcrypt($password);
            $courier->save();
            $maildata = array(
                'name' => $courier->contact_fname . ' ' . $courier->contact_lname,
                'username' => $courier->email,
                'password' => $password
            );
            Mail::to($courier->email)->send(new ResetPasswordMail($maildata));
            return response()->json(array('msg' => 'success', 'response' => 'Password reset email sent successfully!'));
        } else {
            return response()->json(array('msg' => 'error', 'response' => 'Email not found'), 422);
        }
    }
    public function refresh()
    {
        return $this->respondWithToken(auth('couriers')->refresh());
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
        $courier = auth()->guard('couriers')->user();
        return response()->json($courier);
    }
    public function logout()
    {
        auth()->guard('couriers')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
