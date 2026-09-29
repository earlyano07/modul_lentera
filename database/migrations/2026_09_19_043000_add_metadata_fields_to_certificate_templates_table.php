<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('certificate_templates', function (Blueprint $table) {
            $table->string('signer_mode')->default('school_counselor')->after('signer_title');
            $table->string('default_signer_name')->nullable()->after('signer_mode');
            $table->string('default_signer_nip')->nullable()->after('default_signer_name');
            $table->string('cert_number_prefix')->default('LTR')->after('default_signer_nip');
            $table->string('cert_number_format')->default('No: {PREFIX}/{YEAR}/{CLASS}/{ID}')->after('cert_number_prefix');
            $table->string('date_type')->default('completion_date')->after('cert_number_format');
            $table->date('fixed_date')->nullable()->after('date_type');
        });
    }

    public function down(): void
    {
        Schema::table('certificate_templates', function (Blueprint $table) {
            $table->dropColumn([
                'signer_mode',
                'default_signer_name',
                'default_signer_nip',
                'cert_number_prefix',
                'cert_number_format',
                'date_type',
                'fixed_date',
            ]);
        });
    }
};
