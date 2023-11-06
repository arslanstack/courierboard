<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('lname');
            $table->string('phone')->unique();
            $table->string('fax')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->string('mail_address_1')->nullable();
            $table->string('mail_address_2')->nullable();
            $table->string('company')->nullable();
            $table->tinyInteger('company_type')->default(0)->comment('0: Shipper 1: 3rd Party 2: Freight 3: Courier');
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('zip')->nullable();


            $table->tinyInteger('status')->default(1)->comment('0: inactive, 1: active');
            
            $table->string('alert_email_1')->nullable();
            $table->string('alert_email_2')->nullable();

            $table->tinyInteger('alert_freight')->default(1)->comment('0: yes , 1: no');
            $table->tinyInteger('alert_vehicle')->default(1)->comment('0: yes , 1: no');
            $table->tinyInteger('alert_rpf')->default(1)->comment('0: yes , 1: no');
            $table->tinyInteger('alert_driver')->default(1)->comment('0: yes , 1: no');

            $table->string('account_no')->nullable();
            $table->string('title')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('username')->nullable();

            $table->string('other1')->nullable();
            $table->string('other2')->nullable();
            $table->string('other3')->nullable();
            $table->string('other4')->nullable();
            $table->string('other5')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
