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
        Schema::create('pertanyaan', function (Blueprint $table) {
            $table->id('id_pertanyaan');
            $table->foreignId('id_user')
                ->constrained('user', 'id_user')
                ->onDelete('cascade');
            $table->string('judul');
            $table->text('deskripsi');
            $table->integer('jumlah_vote')
                ->default(0);
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan');
    }
};
