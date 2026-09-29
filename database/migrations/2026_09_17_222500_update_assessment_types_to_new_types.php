<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update existing 'lkpd' to 'refleksi_diri'
        DB::table('assessments')
            ->where('jenis', 'lkpd')
            ->update(['jenis' => 'refleksi_diri']);

        // Update titles that have 'Lembar Kerja Peserta Didik (LKPD)' to 'Refleksi Diri'
        DB::table('assessments')
            ->where('judul', 'like', '%Lembar Kerja Peserta Didik (LKPD)%')
            ->get()
            ->each(function ($a) {
                $newJudul = str_replace('Lembar Kerja Peserta Didik (LKPD)', 'Refleksi Diri', $a->judul);
                DB::table('assessments')->where('id', $a->id)->update(['judul' => trim($newJudul)]);
            });
    }

    public function down(): void
    {
        DB::table('assessments')
            ->where('jenis', 'refleksi_diri')
            ->update(['jenis' => 'lkpd']);
    }
};
