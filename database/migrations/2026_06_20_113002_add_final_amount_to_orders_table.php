<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('orders', function (Blueprint $table) {
        // Tambahkan paid_at jika belum ada
        if (!Schema::hasColumn('orders', 'paid_at')) {
            $table->timestamp('paid_at')->nullable();
        }
        // Tambahkan final_amount
        if (!Schema::hasColumn('orders', 'final_amount')) {
            $table->decimal('final_amount', 12, 2)->nullable();
        }
    });
}

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('final_amount');
        });
    }
};
