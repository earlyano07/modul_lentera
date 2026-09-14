<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->string('subtitle')->nullable()->after('judul');
            $table->text('fokus_utama')->nullable()->after('deskripsi');
            $table->string('ilustrasi')->nullable()->after('fokus_utama');
        });

        Schema::table('materials', function (Blueprint $table) {
            $table->string('jenis')->default('materi')->after('judul');
            $table->string('file_path')->nullable()->after('video');
        });
    }

    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn(['subtitle', 'fokus_utama', 'ilustrasi']);
        });

        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn(['jenis', 'file_path']);
        });
    }
};
