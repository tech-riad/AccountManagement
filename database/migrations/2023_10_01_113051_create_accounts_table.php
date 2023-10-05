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
            $table->unsignedBigInteger('category_id');
            $table->enum('transaction_type', ['income', 'expense']);
            $table->unsignedBigInteger('account_method');
            $table->string('customer_name');
            $table->date('payment_date');
            $table->decimal('amount', 10, 2);
            $table->string('created_by');
            $table->string('received_by');
            $table->longtext('description')->nullable();
            $table->unsignedBigInteger('product_name')->nullable();
            $table->enum('status', ['paid', 'canceled','pending'])->default('pending');
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
