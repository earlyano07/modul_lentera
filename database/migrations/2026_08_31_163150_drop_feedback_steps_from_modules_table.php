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
        Schema::table('modules', function (Blueprint $table) {
            if (Schema::hasColumn('modules', 'feedback_step1')) {
                $table->dropColumn(['feedback_step1', 'feedback_step2', 'feedback_step3']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->text('feedback_step1')->nullable();
            $table->text('feedback_step2')->nullable();
            $table->text('feedback_step3')->nullable();
        });
    }
};
