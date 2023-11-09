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
        Schema::create('couriers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('zip');
            $table->tinyInteger('company_type')->default(0)->comment('0: courier company, 1: others');
            $table->string('website')->nullable();
            $table->integer('drivers');
            $table->string('mc_number')->nullable();
            $table->string('insurance_name');
            $table->string('gen_insurance');
            $table->string('cargo_insurance');
            $table->string('other_insurance')->nullable();
            $table->string('declaration')->nullable();
            $table->string('contact_fname');
            $table->string('contact_lname');
            $table->string('contact_title');
            $table->string('company_phone');
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('username')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0 : inactive, 1 : active');
            $table->string('other1')->nullable();
            $table->string('other2')->nullable();
            $table->string('other3')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('couriers');
    }
};
