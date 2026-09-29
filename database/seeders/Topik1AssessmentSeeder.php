<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\Module;
use Illuminate\Database\Seeder;

class Topik1AssessmentSeeder extends Seeder
{
    public function run(): void
    {
        $topik1 = Module::where('urutan', 1)->first();
        if (!$topik1) {
            return;
        }

        // 1. PENILAIAN DIRI
        $penilaianDiri = Assessment::updateOrCreate(
            [
                'module_id' => $topik1->id,
                'jenis' => 'penilaian_diri',
            ],
            [
                'judul' => 'Penilaian Diri',
                'urutan' => 1,
                'max_skor' => 24,
                'deskripsi' => 'Petunjuk: Pilih satu jawaban yang paling sesuai dengan dirimu.',
                'catatan' => null,
            ]
        );
        $penilaianDiri->questions()->delete();

        $soalPenilaianDiri = [
            'Saya dapat membedakan bercanda dengan perilaku yang dapat menyakiti orang lain.',
            'Saya memperhatikan perasaan teman ketika melihat perlakuan yang tidak menyenangkan.',
            'Saya menyadari bahwa perundungan dapat memberikan dampak kepada korban.',
            'Saya tidak langsung menganggap seseorang baik-baik saja hanya karena ia tersenyum.',
            'Saya dapat mengenali perubahan perilaku seseorang ketika mengalami masalah.',
            'Saya menyadari bahwa teman yang melihat perundungan juga memiliki peran.',
        ];

        foreach ($soalPenilaianDiri as $idx => $pernyataan) {
            $q = $penilaianDiri->questions()->create([
                'question' => $pernyataan,
                'urutan' => $idx + 1,
                'type' => 'multiple_choice',
                'score' => 4,
            ]);

            $options = [
                ['label' => 'SS', 'option' => 'Sangat Sesuai', 'score' => 4, 'is_correct' => true],
                ['label' => 'S', 'option' => 'Sesuai', 'score' => 3, 'is_correct' => false],
                ['label' => 'KS', 'option' => 'Kurang Sesuai', 'score' => 2, 'is_correct' => false],
                ['label' => 'TS', 'option' => 'Tidak Sesuai', 'score' => 1, 'is_correct' => false],
            ];

            foreach ($options as $opt) {
                $q->options()->create($opt);
            }
        }

        // 2. REFLEKSI DIRI
        $refleksiDiri = Assessment::updateOrCreate(
            [
                'module_id' => $topik1->id,
                'jenis' => 'refleksi_diri',
            ],
            [
                'judul' => 'Refleksi Diri',
                'urutan' => 2,
                'max_skor' => 16,
                'deskripsi' => "Bacalah situasi berikut.\nRaka sering dipanggil dengan julukan yang tidak disukainya. Ketika ditanya, Raka mengatakan, “Tidak apa-apa.” Namun, setelah beberapa waktu, Raka mulai lebih sering menyendiri.\nMenurutmu, apa yang perlu diperhatikan?\nPilih jawaban yang paling sesuai.",
                'catatan' => 'Catatan: Butir nomor 4 adalah pernyataan negatif sehingga skornya dibalik.',
            ]
        );
        $refleksiDiri->questions()->delete();

        $soalRefleksiDiri = [
            [
                'question' => 'Perasaan Raka perlu diperhatikan meskipun ia mengatakan tidak apa-apa.',
                'options' => [
                    ['label' => 'SS', 'option' => 'Sangat Sesuai', 'score' => 4, 'is_correct' => true],
                    ['label' => 'S', 'option' => 'Sesuai', 'score' => 3, 'is_correct' => false],
                    ['label' => 'KS', 'option' => 'Kurang Sesuai', 'score' => 2, 'is_correct' => false],
                    ['label' => 'TS', 'option' => 'Tidak Sesuai', 'score' => 1, 'is_correct' => false],
                ],
            ],
            [
                'question' => 'Perubahan perilaku Raka dapat menjadi tanda bahwa ia mengalami masalah.',
                'options' => [
                    ['label' => 'SS', 'option' => 'Sangat Sesuai', 'score' => 4, 'is_correct' => true],
                    ['label' => 'S', 'option' => 'Sesuai', 'score' => 3, 'is_correct' => false],
                    ['label' => 'KS', 'option' => 'Kurang Sesuai', 'score' => 2, 'is_correct' => false],
                    ['label' => 'TS', 'option' => 'Tidak Sesuai', 'score' => 1, 'is_correct' => false],
                ],
            ],
            [
                'question' => 'Kita perlu memahami situasi sebelum memberikan penilaian.',
                'options' => [
                    ['label' => 'SS', 'option' => 'Sangat Sesuai', 'score' => 4, 'is_correct' => true],
                    ['label' => 'S', 'option' => 'Sesuai', 'score' => 3, 'is_correct' => false],
                    ['label' => 'KS', 'option' => 'Kurang Sesuai', 'score' => 2, 'is_correct' => false],
                    ['label' => 'TS', 'option' => 'Tidak Sesuai', 'score' => 1, 'is_correct' => false],
                ],
            ],
            [
                'question' => 'Pendapat pelaku saja sudah cukup untuk menentukan bahwa tindakan tersebut tidak bermasalah.',
                'options' => [
                    ['label' => 'SS', 'option' => 'Sangat Sesuai', 'score' => 1, 'is_correct' => false],
                    ['label' => 'S', 'option' => 'Sesuai', 'score' => 2, 'is_correct' => false],
                    ['label' => 'KS', 'option' => 'Kurang Sesuai', 'score' => 3, 'is_correct' => false],
                    ['label' => 'TS', 'option' => 'Tidak Sesuai', 'score' => 4, 'is_correct' => true],
                ],
            ],
        ];

        foreach ($soalRefleksiDiri as $idx => $item) {
            $q = $refleksiDiri->questions()->create([
                'question' => $item['question'],
                'urutan' => $idx + 1,
                'type' => 'multiple_choice',
                'score' => 4,
            ]);

            foreach ($item['options'] as $opt) {
                $q->options()->create($opt);
            }
        }

        // 3. KOMITMEN SAYA
        $komitmenSaya = Assessment::updateOrCreate(
            [
                'module_id' => $topik1->id,
                'jenis' => 'lembar_komitmen',
            ],
            [
                'judul' => 'Komitmen Saya',
                'urutan' => 3,
                'max_skor' => 16,
                'deskripsi' => 'Setelah mengikuti kegiatan ini, seberapa sesuai komitmen berikut dengan dirimu?',
                'catatan' => 'Komitmen utama saya: "Mulai sekarang, saya akan..."',
            ]
        );
        $komitmenSaya->questions()->delete();

        $soalKomitmen = [
            'Saya akan lebih memperhatikan keadaan teman di sekitar saya.',
            'Saya tidak akan langsung menganggap ejekan sebagai candaan.',
            'Saya tidak akan ikut menertawakan teman yang menjadi sasaran.',
            'Saya akan mencari bantuan ketika melihat situasi yang sulit saya tangani sendiri.',
        ];

        foreach ($soalKomitmen as $idx => $pernyataan) {
            $q = $komitmenSaya->questions()->create([
                'question' => $pernyataan,
                'urutan' => $idx + 1,
                'type' => 'multiple_choice',
                'score' => 4,
            ]);

            $options = [
                ['label' => 'SS', 'option' => 'Sangat Sesuai', 'score' => 4, 'is_correct' => true],
                ['label' => 'S', 'option' => 'Sesuai', 'score' => 3, 'is_correct' => false],
                ['label' => 'KS', 'option' => 'Kurang Sesuai', 'score' => 2, 'is_correct' => false],
                ['label' => 'TS', 'option' => 'Tidak Sesuai', 'score' => 1, 'is_correct' => false],
            ];

            foreach ($options as $opt) {
                $q->options()->create($opt);
            }
        }
    }
}
