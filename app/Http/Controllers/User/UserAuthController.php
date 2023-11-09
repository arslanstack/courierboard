<?php

namespace App\Http\Controllers\User;

use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\QuoteRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use App\Mail\ResetPasswordMail;
use Illuminate\Auth\Events\Registered;
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
        $this->middleware('auth:api', ['except' => ['login', 'register', 'resetPassword', 'homepageregister']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function homepageregister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pickup' => 'required',
            'start_point' => 'required',
            'delivery_point' => 'required',
            'dimensions' => 'required',
            'weight' => 'required',
            'pickup_time' => 'required',
            'delivery_time' => 'required',
            'description' => 'required',
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|unique:users',
            'company' => 'required|string|max:255',
            'zip' => 'required|string|max:255',
        ]);
        $validator->setCustomMessages([
            'unique' => 'The :attribute is already taken.',
        ]);

        if ($validator->fails()) {
            if ($validator->errors()->has('email')) {
                return response()->json(['error' => 'Email address is already associated with an account, please log in to post a quote request.'], 422);
            }
            return response()->json(['error' => $validator->errors()], 422); // 422 Unprocessable Entity
        }

        $password = $request->fname . rand(1000, 99999);
        $input = $request->all();
        $geocoded_address = calculate_address($input['zip']);
        $mail_address_1 = $geocoded_address['mail_address'];
        $city = $geocoded_address['city'];
        $state_or_province = $geocoded_address['state_or_province'];
        $country = $geocoded_address['country'];
        $user = User::create([
            'fname' => $input['fname'],
            'lname' => $input['lname'],
            'phone' => $input['phone'],
            'fax' => $input['phone'],
            'email' => $input['email'],
            'password' => bcrypt($password),
            'company' => $input['company'],
            'zip' => $input['zip'],
            'mail_address_1' => $mail_address_1,
            'alert_email_1' => $input['email'],
            'username' => $input['email'],
            'account_no' => rand(100000, 999999),
            'city' => $city,
            'state' => $state_or_province,
            'country' => $country,
        ]);
        $user = User::find($user->id);
        $maildata = array(
            'name' => $input['fname'] . ' ' . $input['lname'],
            'company' => $input['company'],
            'username' => $input['email'],
            'password' => $password
        );

        $mileage = calculate_mileage($input['start_point'], $input['delivery_point']);
        $pickup_address_details = calculate_address($input['start_point']);
        $delivery_address_details = calculate_address($input['delivery_point']);
        $data['pickup_address2'] = $pickup_address_details['mail_address'];
        $data['pickup_city'] = $pickup_address_details['city'];
        $data['pickup_state'] = $pickup_address_details['state_or_province'];
        $data['delivery_address2'] = $delivery_address_details['mail_address'];
        $data['delivery_city'] = $delivery_address_details['city'];
        $data['delivery_state'] = $delivery_address_details['state_or_province'];
        $quote_request = QuoteRequest::create([
            'pickup' => $input['pickup'],
            'start_point' => $input['start_point'],
            'delivery_point' => $input['delivery_point'],
            'mileage' => $mileage,
            'pickup_time' => $input['pickup_time'],
            'delivery_time' => $input['delivery_time'],
            'weight' => $input['weight'],
            'dimensions' => $input['dimensions'],
            'description' => $input['description'],
            'sender_name' => $input['fname'] . ' ' . $input['lname'],
            'sender_phone' => $input['phone'],
            'sender_email' => $input['email'],
            'user_id' => $user->id,
            'pickup_address2' => $pickup_address_details['mail_address'],
            'pickup_city' => $pickup_address_details['city'],
            'pickup_state' => $pickup_address_details['state_or_province'],
            'delivery_address2' => $delivery_address_details['mail_address'],
            'delivery_city' => $delivery_address_details['city'],
            'delivery_state' => $delivery_address_details['state_or_province'],
            'status' => 0,
        ]);
        $quote_request = QuoteRequest::find($quote_request->id);

        Mail::to($input['email'])->send(new WelcomeMail($maildata));
        $credentials = [
            'email' => $input['email'],
            'password' => $password,
        ];
        try {
            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Incorrect email or password'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(array('msg' => 'error', 'response' => 'Something went wrong. Please try again.'));
        }
        $user = Auth::user();
        return response()->json(array('msg' => 'success', 'response' => 'User registered successfully', 'data' => $user, 'quote_request' => $quote_request , 'access_token' => $token, 'token_type' => 'bearer', 'expires_in' => auth()->factory()->getTTL() * 7200));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'phone' => 'required|string|unique:users',
            'fax' => 'required|string|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
            'c_password' => 'required|string',

            'company' => 'required|string|max:255',
            'mail_address_1' => 'required|string|max:255',
            'mail_address_2' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zip' => 'required|string|max:255',
            'company_type' => 'required | integer | max: 4',

        ]);
        $validator->setCustomMessages([
            'unique' => 'The :attribute is already taken.',
        ]);

        if ($validator->fails()) {
            // Check if the email validation failed and return a specific error message and status code
            if ($validator->errors()->has('email')) {
                return response()->json(['error' => 'Email address is already taken'], 422); // 422 Conflict
            }

            // For other validation errors
            return response()->json(['error' => $validator->errors()], 422); // 422 Unprocessable Entity
        }

        $originalPassword = $request->password;
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['alert_email_1'] = $input['email'];
        $input['account_no'] = rand(100000, 999999);
        $input['username'] = $input['email'];
        $user = User::create($input);
        $user = User::find($user->id);
        $maildata = array(
            'name' => $input['fname'] . ' ' . $input['lname'],
            'company' => $input['company'],
            'username' => $input['email'],
            'password' => $originalPassword
        );

        Mail::to($input['email'])->send(new WelcomeMail($maildata));
        $credentials = request(['email', 'password']);
        try {
            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Incorrect email or password'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(array('msg' => 'error', 'response' => 'Something went wrong. Please try again.'));
        }
        $user = Auth::user();
        return response()->json(array('msg' => 'success', 'response' => 'User registered successfully', 'data' => $user, 'access_token' => $token, 'token_type' => 'bearer', 'expires_in' => auth()->factory()->getTTL() * 7200));
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

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $password = $user->fname . rand(1000, 9999);
            $user->password = bcrypt($password);
            $user->save();
            $maildata = array(
                'name' => $user->fname . ' ' . $user->lname,
                'username' => $user->email,
                'password' => $password
            );
            Mail::to($user->email)->send(new ResetPasswordMail($maildata));
            return response()->json(array('msg' => 'success', 'response' => 'Password reset email sent successfully!'));
        } else {
            return response()->json(array('msg' => 'error', 'response' => 'Email not found'), 422);
        }
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
