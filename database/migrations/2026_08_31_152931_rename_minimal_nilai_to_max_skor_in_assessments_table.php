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
        if (Schema::hasColumn('assessments', 'minimal_nilai')) {
            Schema::table('assessments', function (Blueprint $table) {
                $table->renameColumn('minimal_nilai', 'max_skor');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('assessments', 'max_skor')) {
            Schema::table('assessments', function (Blueprint $table) {
                $table->renameColumn('max_skor', 'minimal_nilai');
            });
        }
    }
};
