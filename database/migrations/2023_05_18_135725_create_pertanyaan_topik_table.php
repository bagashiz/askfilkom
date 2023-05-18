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
        Schema::create('pertanyaan_topik', function (Blueprint $table) {
            $table->foreignId('id_pertanyaan')->constrained('pertanyaan', 'id_pertanyaan');
            $table->foreignId('id_topik')->constrained('topik', 'id_topik');
            $table->primary(['id_pertanyaan', 'id_topik']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_topik');
    }
};
