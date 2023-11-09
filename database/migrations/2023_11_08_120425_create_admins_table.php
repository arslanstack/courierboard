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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->tinyInteger('status')->default(1)->comment('0: inactive, 1: active');
            $table->string('phone')->nullable();
            $table->string('username')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();

            // a role can be added using a seprate migration later
            // $table->bigInteger('role_id')->nullable();
            // $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
