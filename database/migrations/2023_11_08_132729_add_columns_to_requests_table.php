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
        Schema::table('requests', function (Blueprint $table) {
            $table->string('pickup_address1')->nullable();
            $table->string('pickup_address2')->nullable();
            $table->string('pickup_city')->nullable();
            $table->string('pickup_state')->nullable();
            $table->string('pickup_company')->nullable();
            $table->string('delivery_address1')->nullable();
            $table->string('delivery_address2')->nullable();
            $table->string('delivery_city')->nullable();
            $table->string('delivery_state')->nullable();
            $table->string('delivery_company')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropColumn('pickup_address1');
            $table->dropColumn('pickup_address2');
            $table->dropColumn('pickup_city');
            $table->dropColumn('pickup_state');
            $table->dropColumn('pickup_company');
            $table->dropColumn('delivery_address1');
            $table->dropColumn('delivery_address2');
            $table->dropColumn('delivery_city');
            $table->dropColumn('delivery_state');
            $table->dropColumn('delivery_company');
        });
    }
};
