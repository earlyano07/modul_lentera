<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificate_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('SERTIFIKAT');
            $table->string('sub_title')->default('PENYELESAIAN LAYANAN MODEL LENTERA');
            $table->string('caption')->default('Latihan Empati Terstruktur untuk Atasi Perundungan');
            $table->text('body_text');
            $table->json('topics_list');
            $table->string('signer_title')->default('Guru Bimbingan dan Konseling');
            $table->string('recap_title')->default('REKAP CAPAIAN LAYANAN');
            $table->text('disclaimer');
            $table->string('commitment_title')->default('KOMITMEN SAYA');
            $table->string('commitment_intro')->default('Setelah mengikuti rangkaian LENTERA, saya berkomitmen untuk:');
            $table->json('commitment_points');
            $table->string('commitment_personal_prompt')->default('Komitmen pribadi saya:');
            $table->string('commitment_personal_subprompt')->default('“Mulai sekarang, saya akan...”');
            $table->string('logo_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificate_templates');
    }
};
