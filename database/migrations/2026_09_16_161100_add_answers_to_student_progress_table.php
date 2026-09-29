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
        Schema::table('student_progress', function (Blueprint $table) {
            if (!Schema::hasColumn('student_progress', 'answers')) {
                $table->json('answers')->nullable()->after('nilai');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_progress', function (Blueprint $table) {
            if (Schema::hasColumn('student_progress', 'answers')) {
                $table->dropColumn('answers');
            }
        });
    }
};
