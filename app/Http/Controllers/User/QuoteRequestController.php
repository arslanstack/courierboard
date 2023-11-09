<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuoteRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuoteRequestController extends Controller
{
    public function index()
    {
        try {
            $quote_requests = QuoteRequest::where('user_id', Auth::id())->orderBy('id', 'DESC')->get();
            return response()->json(['msg' => 'success', 'response' => 'successfully retrieved all quote requests.', 'data' => $quote_requests]);
        } catch (\Exception $e) {
            return response()->json(['msg' => 'error', 'response' => $e->getMessage()], 500);
        }
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'pickup' => 'required',
            'start_point' => 'required',
            'delivery_point' => 'required',
            'dimensions' => 'required',
            'weight' => 'required',
            'pickup_time' => 'required',
            'delivery_time' => 'required',
            'description' => 'required',
            'vehicle_type' => 'required',
            'sender_name' => 'required|string|max:255',
            'sender_email' => 'required|string|email|max:255',
            'sender_phone' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(array('msg' => 'lvl_error', 'response' => $validator->errors()->all()));
        }
        $data['reefer'] = isset($data['reefer']) ? 1 : 0;
        $data['hazmat'] = isset($data['hazmat']) ? 1 : 0;
        $data['lift_gate'] = isset($data['lift_gate']) ? 1 : 0;
        $pickup_address_details = calculate_address($data['start_point']);
        $delivery_address_details = calculate_address($data['delivery_point']);
        $data['pickup_address2'] = $pickup_address_details['mail_address'];
        $data['pickup_city'] = $pickup_address_details['city'];
        $data['pickup_state'] = $pickup_address_details['state_or_province'];
        $data['delivery_address2'] = $delivery_address_details['mail_address'];
        $data['delivery_city'] = $delivery_address_details['city'];
        $data['delivery_state'] = $delivery_address_details['state_or_province'];
        $mileage = calculate_mileage($data['start_point'], $data['delivery_point']);
        $query = QuoteRequest::create([
            'pickup' => $data['pickup'],
            'start_point' => $data['start_point'],
            'delivery_point' => $data['delivery_point'],
            'mileage' => $mileage,
            'pickup_time' => $data['pickup_time'],
            'delivery_time' => $data['delivery_time'],
            'weight' => $data['weight'],
            'dimensions' => $data['dimensions'],
            'description' => $data['description'],
            'sender_name' => $data['sender_name'],
            'sender_phone' => $data['sender_phone'],
            'sender_email' => $data['sender_email'],
            'vehicle_type' => $data['vehicle_type'],
            'reefer' => $data['reefer'],
            'hazmat' => $data['hazmat'],
            'lift_gate' => $data['lift_gate'],
            'pickup_address2' => $data['pickup_address2'],
            'pickup_city' => $data['pickup_city'],
            'pickup_state' => $data['pickup_state'],
            'delivery_address2' => $data['delivery_address2'],
            'delivery_city' => $data['delivery_city'],
            'delivery_state' => $data['delivery_state'],
            'user_id' => Auth::id(),
            'status' => 0,
        ]);
        $query = QuoteRequest::find($query->id);
        $response_status = $query->id;
        if ($response_status > 0) {
            return response()->json(['msg' => 'success', 'response' => 'Quote Request successfully added.', 'query' => $query]);
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
        }
    }

    public function show($id)
    {
        try {
            $quote_request = QuoteRequest::find($id);
            if ($quote_request->user_id != Auth::id()) {
                return response()->json(['msg' => 'error', 'response' => 'You are not authorized to view this quote request.'], 401);
            }
            return response()->json(['msg' => 'success', 'response' => 'successfully retrieved quote request.', 'data' => $quote_request]);
        } catch (\Exception $e) {
            return response()->json(['msg' => 'error', 'response' => $e->getMessage()], 500);
        }
    }

    public function updateAddress(Request $request)
    {
        // dd($request->all());
        $quote_request = QuoteRequest::find($request->id);
        if (!$quote_request) {
            return response()->json(['msg' => 'error', 'response' => 'Quote Request not found.'], 404);
        }
        if ($quote_request->user_id != Auth::id()) {
            return response()->json(['msg' => 'error', 'response' => 'You are not authorized to update this quote request.'], 401);
        }
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'pickup_address1' => 'required',
            'pickup_address2' => 'required',
            'pickup_city' => 'required',
            'pickup_state' => 'required',
            'start_point' => 'required',
            'sender_name' => 'required',
            'sender_phone' => 'required',
            'pickup_company' => 'required',
            'delivery_address1' => 'required',
            'delivery_address2' => 'required',
            'delivery_city' => 'required',
            'delivery_state' => 'required',
            'delivery_point' => 'required',
            'delivery_name' => 'required',
            'delivery_phone' => 'required',
            'delivery_company' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(array('msg' => 'lvl_error', 'response' => $validator->errors()->all()));
        }
        $mileage = calculate_mileage($data['start_point'], $data['delivery_point']);
        $post_status = $quote_request->update([
            'pickup_address1' => $data['pickup_address1'],
            'pickup_address2' => $data['pickup_address2'],
            'pickup_city' => $data['pickup_city'],
            'pickup_state' => $data['pickup_state'],
            'start_point' => $data['start_point'],
            'sender_name' => $data['sender_name'],
            'sender_phone' => $data['sender_phone'],
            'pickup_company' => $data['pickup_company'],
            'delivery_address1' => $data['delivery_address1'],
            'delivery_address2' => $data['delivery_address2'],
            'delivery_city' => $data['delivery_city'],
            'delivery_state' => $data['delivery_state'],
            'delivery_point' => $data['delivery_point'],
            'delivery_name' => $data['delivery_name'],
            'delivery_phone' => $data['delivery_phone'],
            'delivery_company' => $data['delivery_company'],
            'mileage' => $mileage,
            'updated_at' => date('Y-m-d H:i:s'),
            'status' => 0,
        ]);
        if ($post_status > 0) {
            $updatedRecord = QuoteRequest::find($data['id']);
            return response()->json([
                'msg' => 'success',
                'response' => 'Quote Request successfully updated! All quotes provided by courier companies would be sent back for reconsideration provided that the quote request has been updated.',
                'query' => $updatedRecord,
            ]);
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
        }
    }

    public function update(Request $request)
    {
        $quote_request = QuoteRequest::find($request->id);
        if (!$quote_request) {
            return response()->json(['msg' => 'error', 'response' => 'Quote Request not found.'], 404);
        }
        if ($quote_request->user_id != Auth::id()) {
            return response()->json(['msg' => 'error', 'response' => 'You are not authorized to update this quote request.'], 401);
        }
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'pickup' => 'required',
            'start_point' => 'required',
            'delivery_point' => 'required',
            'dimensions' => 'required',
            'weight' => 'required',
            'pickup_time' => 'required',
            'delivery_time' => 'required',
            'description' => 'required',
            'vehicle_type' => 'required',
            'sender_name' => 'required|string|max:255',
            'sender_email' => 'required|string|email|max:255',
            'sender_phone' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(array('msg' => 'lvl_error', 'response' => $validator->errors()->all()));
        }
        $data['reefer'] = isset($data['reefer']) ? 1 : 0;
        $data['hazmat'] = isset($data['hazmat']) ? 1 : 0;
        $data['lift_gate'] = isset($data['lift_gate']) ? 1 : 0;
        $pickup_address_details = calculate_address($data['start_point']);
        $delivery_address_details = calculate_address($data['delivery_point']);
        $data['pickup_address2'] = $pickup_address_details['mail_address'];
        $data['pickup_city'] = $pickup_address_details['city'];
        $data['pickup_state'] = $pickup_address_details['state_or_province'];
        $data['delivery_address2'] = $delivery_address_details['mail_address'];
        $data['delivery_city'] = $delivery_address_details['city'];
        $data['delivery_state'] = $delivery_address_details['state_or_province'];
        $mileage = calculate_mileage($data['start_point'], $data['delivery_point']);
        $post_status = $quote_request->update([
            'pickup' => $data['pickup'],
            'start_point' => $data['start_point'],
            'delivery_point' => $data['delivery_point'],
            'mileage' => $mileage,
            'pickup_time' => $data['pickup_time'],
            'delivery_time' => $data['delivery_time'],
            'weight' => $data['weight'],
            'dimensions' => $data['dimensions'],
            'description' => $data['description'],
            'sender_name' => $data['sender_name'],
            'sender_phone' => $data['sender_phone'],
            'sender_email' => $data['sender_email'],
            'vehicle_type' => $data['vehicle_type'],
            'reefer' => $data['reefer'],
            'hazmat' => $data['hazmat'],
            'lift_gate' => $data['lift_gate'],
            'pickup_address2' => $data['pickup_address2'],
            'pickup_city' => $data['pickup_city'],
            'pickup_state' => $data['pickup_state'],
            'delivery_address2' => $data['delivery_address2'],
            'delivery_city' => $data['delivery_city'],
            'delivery_state' => $data['delivery_state'],
            'user_id' => Auth::id(),
            'updated_at' => date('Y-m-d H:i:s'),
            'status' => 0,
        ]);
        if ($post_status > 0) {
            $updatedRecord = QuoteRequest::find($data['id']);
            return response()->json([
                'msg' => 'success',
                'response' => 'Quote Request successfully updated! All quotes provided by courier companies would be sent back for reconsideration provided that the quote request has been updated.',
                'query' => $updatedRecord,
            ]);
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
        }
    }

    public function destroy(Request $request)
    {
        $data = $request->all();
        $status = QuoteRequest::where('id', $data['id'])->first();
        if ($status->id) {
            if ($status->user_id != Auth::id()) {
                return response()->json(['msg' => 'error', 'response' => 'You are not authorized to delete this quote request.'], 401);
            }
            QuoteRequest::find($data['id'])->delete();
            return response()->json(['msg' => 'success', 'response' => 'Quote Request successfully deleted.']);
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
        }
    }
}
