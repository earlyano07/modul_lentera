<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$a9 = App\Models\Assessment::find(9);
if ($a9 && $a9->questions()->count() === 0) {
    echo "Seeding questions for Assessment #9 ({$a9->judul})...\n";
    
    $q1 = App\Models\Question::create([
        'assessment_id' => $a9->id,
        'question' => 'Komitmen Tindakan: Ketika melihat perundungan (bullying) di kelas atau lingkungan sekolah, apa tindakan nyata yang paling berkomitmen Anda lakukan?',
        'type' => 'multiple_choice',
        'score' => 1,
        'urutan' => 1,
    ]);
    App\Models\QuestionOption::create(['question_id' => $q1->id, 'label' => 'A', 'option' => 'Berani bersuara dan menegur pelaku secara santun serta mengajak teman lain membantu korban', 'is_correct' => true]);
    App\Models\QuestionOption::create(['question_id' => $q1->id, 'label' => 'B', 'option' => 'Mendampingi korban dan segera melapor kepada guru BK atau wali kelas', 'is_correct' => true]);
    App\Models\QuestionOption::create(['question_id' => $q1->id, 'label' => 'C', 'option' => 'Menonton dari kejauhan karena takut terlibat masalah', 'is_correct' => false]);
    App\Models\QuestionOption::create(['question_id' => $q1->id, 'label' => 'D', 'option' => 'Membiarkan saja karena merasa bukan urusan pribadi', 'is_correct' => false]);

    $q2 = App\Models\Question::create([
        'assessment_id' => $a9->id,
        'question' => 'Komitmen Budaya Positif: Bagaimana cara Anda berkomitmen menciptakan suasana pertemanan yang aman dan saling menghargai?',
        'type' => 'multiple_choice',
        'score' => 1,
        'urutan' => 2,
    ]);
    App\Models\QuestionOption::create(['question_id' => $q2->id, 'label' => 'A', 'option' => 'Membiasakan perkataan yang membangun dan menghindari ejekan fisik/verbal', 'is_correct' => true]);
    App\Models\QuestionOption::create(['question_id' => $q2->id, 'label' => 'B', 'option' => 'Mengajak teman yang menyendiri untuk bergabung dalam kegiatan belajar bersama', 'is_correct' => true]);
    App\Models\QuestionOption::create(['question_id' => $q2->id, 'label' => 'C', 'option' => 'Memilih-milih teman hanya yang satu kelompok atau populer saja', 'is_correct' => false]);
    App\Models\QuestionOption::create(['question_id' => $q2->id, 'label' => 'D', 'option' => 'Mengikuti candaan kasar teman asalkan tidak ditegur guru', 'is_correct' => false]);

    echo "Done seeding Assessment #9.\n";
} else {
    echo "Assessment #9 already has questions or not found.\n";
}
