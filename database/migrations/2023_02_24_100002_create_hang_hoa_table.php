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
        Schema::create('hang_hoa', function (Blueprint $table) {
            $table->id();
            $table->char('ma_hang_hoa')->unique();
            $table->string('ten_hang_hoa');
            $table->text('mo_ta')->nullable();
            $table->foreignId('id_loai_hang')->constrained('loai_hang')->cascadeOnDelete();
            $table->string('don_vi_tinh');
            $table->integer('barcode')->nullable();
            $table->char('img')->nullable();
            $table->char('ma_du_an');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hang_hoa');
    }
};
