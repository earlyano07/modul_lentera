<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\Module;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Seeder;

class FinalCommitmentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Setup Module 6 (Tahap Akhir: Lembar Komitmen Siswa)
        $module = Module::updateOrCreate(
            ['urutan' => 6],
            [
                'judul' => 'Lembar Komitmen Siswa',
                'subtitle' => 'Tahap Akhir Layanan Model LENTERA',
                'deskripsi' => 'Nyatakan komitmen perilaku empati dan anti-perundungan Anda setelah menyelesaikan seluruh rangkaian 5 topik pembelajaran Model LENTERA.',
                'status' => true,
            ]
        );

        // 2. Setup Assessment Lembar Komitmen under Module 6
        $assessment = Assessment::firstOrNew(['module_id' => $module->id, 'jenis' => 'lembar_komitmen']);
        $assessment->judul = 'Lembar Komitmen Siswa';
        $assessment->deskripsi = 'Setelah mengikuti seluruh rangkaian 5 topik Model LENTERA, nyatakan komitmen perilaku empati dan anti-perundungan Anda berikut ini.';
        $assessment->catatan = 'Komitmen ini akan dicantumkan pada halaman belakang Sertifikat Layanan Model LENTERA Anda.';
        $assessment->urutan = 1;
        $assessment->save();

        // 3. Question 1 (Checklist)
        $qChecklist = Question::firstOrNew([
            'assessment_id' => $assessment->id,
            'type' => 'checklist',
        ]);
        $qChecklist->question = 'Setelah mengikuti rangkaian layanan Model LENTERA, saya berkomitmen untuk:';
        $qChecklist->urutan = 1;
        $qChecklist->score = 0;
        $qChecklist->save();

        $standardOptions = [
            ['label' => 'A', 'option' => 'Menghargai perasaan dan keberadaan orang lain'],
            ['label' => 'B', 'option' => 'Tidak ikut melakukan atau menyebarkan perundungan'],
            ['label' => 'C', 'option' => 'Berusaha memahami sudut pandang dan perasaan orang lain'],
            ['label' => 'D', 'option' => 'Menunjukkan kepedulian dan membantu teman yang mengalami kesulitan'],
            ['label' => 'E', 'option' => 'Ikut menciptakan lingkungan pertemanan yang aman, nyaman, dan saling menghargai'],
        ];

        $existingOptions = $qChecklist->options;
        if ($existingOptions->count() < count($standardOptions)) {
            $qChecklist->options()->delete();
            foreach ($standardOptions as $opt) {
                QuestionOption::create([
                    'question_id' => $qChecklist->id,
                    'label' => $opt['label'],
                    'option' => $opt['option'],
                    'score' => 0,
                    'is_correct' => false,
                ]);
            }
        }

        // 4. Question 2 (Essay)
        $qEssay = Question::firstOrNew([
            'assessment_id' => $assessment->id,
            'type' => 'essay',
        ]);
        $qEssay->question = 'Komitmen pribadi saya:';
        $qEssay->urutan = 2;
        $qEssay->score = 0;
        $qEssay->save();
    }
}
