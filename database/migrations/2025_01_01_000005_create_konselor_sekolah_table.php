<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konselor_sekolah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('konselor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['konselor_id', 'school_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konselor_sekolah');
    }
};
