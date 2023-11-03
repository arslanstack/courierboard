<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = "users"; // table name

    protected $fillable = [
        'fname',
        'lname',
        'phone',
        'email',
        'password',
        'mail_address_1',
        'mail_address_2',
        'company',
        'company_type',
        'city',
        'state',
        'country',
        'zip',
        'status',
        'alert_email_1',
        'alert_email_2',
        'alert_freight',
        'alert_vehicle',
        'alert_rpf',
        'alert_driver',
        'account_no',
        'title',
        'username',
        'other1',
        'other2',
        'other3',
        'other4',
        'other5',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
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
