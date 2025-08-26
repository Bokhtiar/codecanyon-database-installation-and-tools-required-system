<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->string('license_key')->unique();
            $table->string('domain');
            $table->enum('status', ['active', 'inactive', 'expired', 'suspended', 'pending'])->default('pending');
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->string('purchase_code')->nullable();
            $table->string('buyer_email')->nullable();
            $table->string('item_id')->nullable();
            $table->string('item_name')->nullable();
            $table->timestamp('support_until')->nullable();
            $table->enum('license_type', ['regular', 'extended', 'lifetime'])->default('regular');
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['domain', 'status']);
            $table->index(['license_key', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('licenses');
    }
}; 