<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    use HasFactory;

    protected $table = 'requests';

    protected $fillable = [
        'pickup',
        'start_point',
        'delivery_point',
        'mileage',
        'pickup_time',
        'delivery_time',
        'weight',
        'dimensions',
        'description',
        'vehicle_type',
        'reefer',
        'hazmat',
        'lift_gate',
        'sender_name',
        'sender_phone',
        'sender_email',
        'user_id',
        'courier_id',
        'quote_id',
        'transaction_id',
        'status',
        'other1',
        'other2',
        'other3',
        'pickup_address1',
        'pickup_address2',
        'pickup_city',
        'pickup_state',
        'pickup_company',
        'delivery_address1',
        'delivery_address2',
        'delivery_city',
        'delivery_state',
        'delivery_company',
        'delivery_name',
        'delivery_phone',
        'updated_at',
    ];
}
