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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('banner')->nullable();
            $table->text('address');
            $table->string('whatsapp');
            $table->text('shipping_provider')->nullable();
            $table->text('shipping_api_key')->nullable(); 
            $table->text('shipping_area_id')->nullable(); 
            $table->string('email_notification')->nullable();
            $table->boolean('is_use_payment_gateway')->default(false);
            $table->string('area_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }

};
