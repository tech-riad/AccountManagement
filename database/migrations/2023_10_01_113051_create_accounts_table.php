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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_method', 255);
            $table->string('customer_name');
            $table->date('payment_date');
            $table->decimal('amount', 10, 2);
            $table->string('created_by');
            $table->longtext('description');
            $table->string('category_type')->nullable();
            $table->foreignId('product_name')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
