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
        Schema::create('vote', function (Blueprint $table) {
            $table->id('id_vote');
            $table->foreignId('id_user')->constrained('user', 'id_user');
            $table->foreignId('id_pertanyaan')->nullable()->constrained('pertanyaan', 'id_pertanyaan');
            $table->foreignId('id_jawaban')->nullable()->constrained('jawaban', 'id_jawaban');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vote');
    }
};
