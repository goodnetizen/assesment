<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('transactions');
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->timestamps();
            $table->foreignUuid('merchant_id')->constrained();
            $table->foreignUuid('outlet_id')->constrained();
            $table->dateTime('transaction_time')->index();
            $table->string('staff');
            $table->decimal('pay_amount', $precision = 13, $scale = 4)->default(0);
            $table->string('payment_type')->nullable();
            $table->string('customer_name');
            $table->decimal('tax', $precision = 13, $scale = 4)->default(0);
            $table->decimal('change_amount', $precision = 13, $scale = 4)->default(0);
            $table->decimal('total_amount', $precision = 13, $scale = 4)->default(0);
            $table->string('payment_status')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
