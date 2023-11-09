<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentCards extends Model
{
    use HasFactory;

    protected $table = 'payment_cards';

    protected $fillable = [
        'type',
        'owner_id',
        'company_name',
        'fname',
        'lname',
        'address1',
        'address2',
        'zip',
        'city',
        'state',
        'country',
        'card_number',
        'cvv',
        'expiry',
        'status',
        'other1',
        'other2',
    ];
}
