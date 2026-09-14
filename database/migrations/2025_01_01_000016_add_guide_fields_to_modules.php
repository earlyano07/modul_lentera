<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->text('guide_modeling')->nullable();
            $table->text('guide_role_playing')->nullable();
            $table->text('guide_feedback')->nullable();
            $table->text('guide_transfer')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn(['guide_modeling', 'guide_role_playing', 'guide_feedback', 'guide_transfer']);
        });
    }
};
