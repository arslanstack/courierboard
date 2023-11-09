<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Courier extends Authenticatable implements JWTSubject 
{
    use HasFactory, Notifiable;

    protected $table = 'couriers';

    protected $fillable = [
        'name',
        'address1',
        'address2',
        'city',
        'state',
        'country',
        'zip',
        'company_type',
        'website',
        'drivers',
        'mc_number',
        'insurance_name',
        'gen_insurance',
        'cargo_insurance',
        'other_insurance',
        'declaration',
        'contact_fname',
        'contact_lname',
        'contact_title',
        'company_phone',
        'mobile',
        'email',
        'password',
        'username',
        'other1',
        'other2',
        'other3',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
