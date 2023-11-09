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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->date('pickup');
            $table->string('start_point');
            $table->string('delivery_point');
            $table->string('mileage')->nullable();
            $table->time('pickup_time'); 
            $table->time('delivery_time');
            $table->float('weight');
            $table->string('dimensions');
            $table->text('description');
            $table->tinyInteger('vehicle_type')->default(0)->comment('0 - any, 1 - car, 2 - minivan, 3 - suv, 4  - cargo van, 5 - sprinter, 6 - covered pickup, 7 - 16 ft Box Truck, 8 - and so on till 14 - Tractor Trailer');
            $table->tinyInteger('reefer')->default(1)->comment('0 : yes, 1 : no');
            $table->tinyInteger('hazmat')->default(1)->comment('0 : yes, 1 : no');
            $table->tinyInteger('lift_gate')->default(1)->comment('0 : yes, 1 : no');
            $table->string('sender_name');
            $table->string('sender_phone');
            $table->string('sender_email');
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('courier_id')->nullable();
            $table->bigInteger('quote_id')->nullable();
            $table->bigInteger('transaction_id')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 : listed, 1 : bid , 2 : accepted 3 : completed, 4: removed');
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
        Schema::dropIfExists('requests');
    }
};
