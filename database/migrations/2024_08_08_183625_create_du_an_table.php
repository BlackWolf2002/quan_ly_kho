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
        Schema::create('du_an', function (Blueprint $table) {
            $table->id();
            $table->char('ma_du_an')->unique();
            $table->string('ten_du_an',50);
            $table->date('ngay_bat_dau');
            $table->date('ngay_ket_thuc');
            $table->boolean('tinh_trang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('du_an');
    }
};
