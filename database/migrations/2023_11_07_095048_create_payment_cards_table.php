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
        Schema::create('payment_cards', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->default(0)->comment('0 : User, 1 : Courier');
            $table->bigInteger('owner_id');
            $table->string('company_name')->nullable();
            $table->string('fname');
            $table->string('lname');
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->string('zip');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('card_number');
            $table->string('cvv');
            $table->string('expiry');
            $table->tinyInteger('status')->default(1)->comment('0 : inactive, 1 : active');
            $table->string('other1')->nullable();
            $table->string('other2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_cards');
    }
};
