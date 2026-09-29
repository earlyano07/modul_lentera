<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\Kelas;
use App\Models\Konselor;
use App\Models\Material;
use App\Models\Module;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Role;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles
        $this->call(RoleSeeder::class);

        // 2. Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@lentera.test'],
            [
                'role_id' => Role::ADMIN,
                'nama' => 'Administrator',
                'email' => 'admin@lentera.test',
                'password' => Hash::make('password'),
            ]
        );

        // 3. Schools
        $school1 = School::create([
            'nama' => 'SMP Negeri Model Blitar',
            'alamat' => 'Jl. Jenderal Sudirman No. 10, Blitar',
            'telepon' => '0342-801234',
            'npsn' => '20100001',
            'status' => true,
        ]);

        $school2 = School::create([
            'nama' => 'SMK Negeri 2 Bandung',
            'alamat' => 'Jl. Ciliwung No. 4, Bandung',
            'telepon' => '022-7654321',
            'npsn' => '20200002',
            'status' => true,
        ]);

        // 4. Kelas
        $kelas1 = Kelas::create(['school_id' => $school1->id, 'nama_kelas' => 'VIII A', 'tingkat' => 'VIII', 'tahun_ajaran' => '2025/2026']);
        $kelas2 = Kelas::create(['school_id' => $school1->id, 'nama_kelas' => 'VIII B', 'tingkat' => 'VIII', 'tahun_ajaran' => '2025/2026']);
        $kelas3 = Kelas::create(['school_id' => $school2->id, 'nama_kelas' => 'XI TKJ 1', 'tingkat' => 'XI', 'tahun_ajaran' => '2025/2026']);

        // 5. Konselor
        $konselorUser1 = User::create([
            'role_id' => Role::KONSELOR,
            'nama' => 'Novia Hendratno, M.Pd.',
            'email' => 'novia@lentera.test',
            'password' => Hash::make('password'),
        ]);
        $konselor1 = Konselor::create([
            'user_id' => $konselorUser1->id,
            'nip' => '198501012010011001',
            'no_hp' => '081234567890',
        ]);
        $konselor1->schools()->attach([$school1->id, $school2->id]);

        $konselorUser2 = User::create([
            'role_id' => Role::KONSELOR,
            'nama' => 'Budi Santoso, M.Pd.',
            'email' => 'konselor2@lentera.test',
            'password' => Hash::make('password'),
        ]);
        $konselor2 = Konselor::create([
            'user_id' => $konselorUser2->id,
            'nip' => '199003152015021002',
            'no_hp' => '082345678901',
        ]);
        $konselor2->schools()->attach([$school2->id]);

        // 6. Students
        $studentNames = [
            ['nama' => 'Andi Pratama', 'nis' => '10001', 'jk' => 'L', 'kelas' => $kelas1->id],
            ['nama' => 'Budi Setiawan', 'nis' => '10002', 'jk' => 'L', 'kelas' => $kelas1->id],
            ['nama' => 'Citra Dewi', 'nis' => '10003', 'jk' => 'P', 'kelas' => $kelas1->id],
            ['nama' => 'Dina Rahmawati', 'nis' => '10004', 'jk' => 'P', 'kelas' => $kelas2->id],
            ['nama' => 'Eko Prasetyo', 'nis' => '10005', 'jk' => 'L', 'kelas' => $kelas2->id],
            ['nama' => 'Fitri Handayani', 'nis' => '20001', 'jk' => 'P', 'kelas' => $kelas3->id],
            ['nama' => 'Gilang Ramadhan', 'nis' => '20002', 'jk' => 'L', 'kelas' => $kelas3->id],
        ];

        foreach ($studentNames as $i => $s) {
            $user = User::create([
                'role_id' => Role::SISWA,
                'nama' => $s['nama'],
                'username' => 'siswa' . ($i + 1),
                'email' => 'siswa' . ($i + 1) . '@lentera.test',
                'password' => Hash::make('password'),
            ]);
            Student::create([
                'user_id' => $user->id,
                'kelas_id' => $s['kelas'],
                'nis' => $s['nis'],
                'jenis_kelamin' => $s['jk'],
                'tanggal_lahir' => fake()->dateTimeBetween('-18 years', '-15 years')->format('Y-m-d'),
            ]);
        }

        // 7. Modules (5 Topics)
        $modules = [
            [
                'judul' => 'Empathy Awareness',
                'subtitle' => 'kesadaran terhadap bullying',
                'deskripsi' => 'Mengenali dan memahami konsep dasar empati serta pentingnya dalam kehidupan sosial.',
                'fokus_utama' => 'Menyadari bentuk-bentuk bullying dan dampaknya bagi diri sendiri dan orang lain.',
                'ilustrasi' => 'topics/empathy_awareness.png',
                'urutan' => 1,
            ],
            [
                'judul' => 'Emotional Empathy',
                'subtitle' => 'mengenali dan memahami emosi korban',
                'deskripsi' => 'Mengembangkan kemampuan merasakan emosi orang lain secara mendalam.',
                'fokus_utama' => 'Mengenal dan memahami perasaan seperti takut, sedih, malu, atau tertekan yang dialami korban.',
                'ilustrasi' => 'topics/emotional_empathy.png',
                'urutan' => 2,
            ],
            [
                'judul' => 'Cognitive Empathy / Perspective Taking',
                'subtitle' => 'melihat situasi dari sudut pandang orang lain',
                'deskripsi' => 'Melatih kemampuan memahami sudut pandang dan pemikiran orang lain.',
                'fokus_utama' => 'Belajar memahami alasan, perasaan, dan pengalaman orang lain dalam situasi tertentu.',
                'ilustrasi' => 'topics/cognitive_empathy.png',
                'urutan' => 3,
            ],
            [
                'judul' => 'Empathic Response',
                'subtitle' => 'memberikan respons yang mendukung dan membantu',
                'deskripsi' => 'Belajar merespons secara tepat dan efektif terhadap emosi orang lain.',
                'fokus_utama' => 'Memberikan dukungan, bantuan, atau respons positif kepada teman yang membutuhkan.',
                'ilustrasi' => 'topics/empathic_response.png',
                'urutan' => 4,
            ],
            [
                'judul' => 'Prosocial Behavior',
                'subtitle' => 'mewujudkan empati dalam perilaku sehari-hari',
                'deskripsi' => 'Menerapkan perilaku prososial dan kepedulian sosial dalam kehidupan sehari-hari.',
                'fokus_utama' => 'Menerapkan empati dalam perilaku prososial untuk menciptakan lingkungan sekolah yang aman dan inklusif.',
                'ilustrasi' => 'topics/prosocial_behavior.png',
                'urutan' => 5,
            ],
        ];

        foreach ($modules as $m) {
            $data = array_merge($m, ['status' => true]);
            if ($m['urutan'] >= 1 && $m['urutan'] <= 5) {
                $data['guide_modeling'] = '<p>Konselor mengarahkan jalannya modeling dengan langkah-langkah berikut:</p><ol><li><strong>Pemutaran Video & Pengamatan</strong><p>Putar video modeling yang relevan. Instruksikan siswa untuk mengamati gerak-gerik, mimik wajah, dan dialog antar tokoh di dalam video.</p></li><li><strong>Refleksi & Tanya Jawab</strong><p>Ajak siswa melakukan tanya jawab singkat mengenai perilaku yang mereka saksikan. Tekankan pada perbedaan bercanda dan bullying.</p></li></ol>';
                $data['guide_role_playing'] = '<p>Konselor membagi kelompok dan memandu role playing:</p><ol><li><strong>Pembagian Skenario & Peran</strong><p>Bagi kelas menjadi kelompok kecil (3-4 orang). Berikan kartu situasi dan minta mereka berbagi peran secara adil sesuai skenario.</p></li><li><strong>Simulasi & Peragaan</strong><p>Arahkan kelompok untuk mensimulasikan situasi di kartu secara bergantian, lalu diskusikan pertanyaan pemantik dalam kelompok.</p></li></ol>';
                $data['guide_feedback'] = '<p>Berikan umpan balik langsung setelah siswa mempraktikkan skenario Kartu Situasi di depan kelas:</p><ol><li><strong>Penguatan Sosial (Social Reinforcement)</strong><p>Puji keaktifan kelompok dalam bermain peran. Sebutkan secara spesifik tindakan empati yang diperagakan dengan baik, seperti cara menenangkan korban, nada bicara yang tenang, atau gestur bersahabat.</p></li><li><strong>Koreksi & Modifikasi Respon</strong><p>Jika ada respon yang kurang tepat (misal: malah ikut terpancing emosi, menyalahkan korban, atau mengabaikan situasi), diskusikan bersama bagaimana cara memperbaikinya dan peragakan ulang respon yang benar.</p></li><li><strong>Diskusi Reflektif</strong><p>Ajak siswa lain (audiens) untuk mengemukakan pendapat mereka mengenai kelebihan dan kekurangan simulasi yang ditampilkan temannya untuk menumbuhkan pemahaman kolektif.</p></li></ol>';
                $data['guide_transfer'] = '<p>Mendorong integrasi perilaku empati dalam kehidupan sehari-hari siswa:</p><ol><li><strong>Pengisian Lembar Kerja (LKPD)</strong><p>Membagikan LKPD Ujian Online atau mengarahkan peserta didik membuka menu asesmen LKPD di platform LENTERA untuk dijawab secara objektif.</p></li><li><strong>Rencana Tindakan Nyata & Komitmen</strong><p>Meminta siswa merancang satu rencana aksi nyata yang akan mereka terapkan selama satu minggu ke depan dan mengisi Lembar Komitmen Perilaku Anti-Bullying.</p></li></ol>';
            }
            $module = Module::create($data);

            // Add 2 facilities for each Topic (urutan 1 to 5)
            if ($m['urutan'] >= 1 && $m['urutan'] <= 5) {
                // 1. Video / Ilustrasi Kejadian
                Material::create([
                    'module_id' => $module->id,
                    'judul' => 'Video / Ilustrasi Kejadian: ' . $m['judul'],
                    'jenis' => Material::JENIS_VIDEO,
                    'isi' => '<p>Silakan tonton video / ilustrasi kejadian untuk mengenali situasi empati terkait topik ini.</p>',
                    'video' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'urutan' => 1,
                ]);

                // Specific kartu situasi details based on Topic order
                $kartuDetails = match ($m['urutan']) {
                    1 => [
                        'judul' => 'Diam Bukan Berarti Setuju',
                        'situasi' => 'Dimas sering diam saat teman-temannya mengejek seseorang. Mereka menganggap Dimas setuju karena tidak membela. Padahal Dimas takut jika ikut bicara nanti diejek juga.',
                        'peran' => "Dimas (siswa)\nDua teman\nSatu pelaku",
                        'diskusi' => "Mengapa Dimas diam?\nBagaimana perasaan Dimas?\nApa yang mungkin Dimas pikirkan?\nApa yang bisa dilakukan Dimas?",
                    ],
                    2 => [
                        'judul' => 'Menghargai Perasaan Teman',
                        'situasi' => 'Lina menangis sendirian di pojok kelas setelah dituduh mencontek oleh temannya, padahal dia belajar semalaman. Teman-teman lain hanya memandangnya dan berbisik.',
                        'peran' => "Lina (korban)\nTeman penuduh\nTeman yang berbisik",
                        'diskusi' => "Bagaimana perasaan Lina saat dituduh?\nKenapa teman-teman lain malah berbisik?\nApa respons empati emosional yang tepat?",
                    ],
                    3 => [
                        'judul' => 'Melihat dari Sudut Pandang Lain',
                        'situasi' => 'Budi tidak ingin bermain dengan Adi karena Adi selalu memakai sepatu yang usang dan kaos kaki bolong. Budi tidak tahu bahwa Adi bekerja membantu ayahnya setelah sekolah.',
                        'peran' => "Budi (siswa)\nAdi (siswa)\nAyah Adi",
                        'diskusi' => "Mengapa Adi memakai sepatu usang?\nBagaimana sudut pandang Adi terhadap ejekan Budi?\nBagaimana jika Budi mengetahui kenyataannya?",
                    ],
                    4 => [
                        'judul' => 'Memberikan Dukungan Nyata',
                        'situasi' => 'Roni terlihat sangat sedih karena tidak memiliki uang untuk membayar uang buku. Bimo melihat Roni murung dan memegang buku lamanya yang robek.',
                        'peran' => "Roni (siswa)\nBimo (teman Budi)\nPenjual buku",
                        'diskusi' => "Bagaimana cara Bimo memberikan respons empati?\nApa kalimat yang sopan untuk menghibur Roni?\nApa tindakan konkret yang bisa dilakukan?",
                    ],
                    5 => [
                        'judul' => 'Mewujudkan Empati dalam Aksi',
                        'situasi' => 'Saat jam istirahat, kelompok siswa menolak Siti bergabung makan siang bersama karena pakaian Siti tampak sederhana dan berasal dari desa.',
                        'peran' => "Siti (siswa baru)\nKelompok penolak\nSiswa yang mengajak Siti bergabung",
                        'diskusi' => "Bagaimana dampak penolakan sosial terhadap Siti?\nApa tindakan prososial yang bisa diambil oleh siswa lain?\nBagaimana cara menciptakan inklusi di sekolah?",
                    ],
                };

                // 2. Kartu Situasi (Role Playing)
                Material::create([
                    'module_id' => $module->id,
                    'judul' => $kartuDetails['judul'],
                    'jenis' => Material::JENIS_KARTU_SITUASI,
                    'situasi' => $kartuDetails['situasi'],
                    'peran' => $kartuDetails['peran'],
                    'diskusi' => $kartuDetails['diskusi'],
                    'urutan' => 2,
                ]);
            }

            // Add assessment for modules 2-5 (Topik 1 is seeded by Topik1AssessmentSeeder)
            if ($m['urutan'] > 1) {
                $assessment = Assessment::create([
                    'module_id' => $module->id,
                    'judul' => 'Lembar Kerja Peserta Didik (LKPD) ' . $m['judul'],
                    'jenis' => 'lkpd',
                    'max_skor' => 0,
                    'urutan' => 1,
                ]);

                // Add sample questions (3 per assessment)
                $sampleQuestions = [
                    [
                        'question' => 'Bagian 1: Mengenali Situasi - Berdasarkan video/ilustrasi, manakah tindakan yang menunjukkan pemahaman situasi perundungan yang tepat?',
                        'options' => [
                            ['label' => 'A', 'option' => 'Menyadari bahwa ucapan kasar walau bercanda dapat melukai perasaan korban', 'is_correct' => true],
                            ['label' => 'B', 'option' => 'Menganggap perundungan verbal sebagai hal biasa antar teman', 'is_correct' => false],
                            ['label' => 'C', 'option' => 'Membiarkan perundungan terjadi selama tidak ada kontak fisik', 'is_correct' => false],
                            ['label' => 'D', 'option' => 'Menyalahkan korban karena bersikap terlalu sensitif', 'is_correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Bagian 2: Penilaian Diri - Bagaimana Anda menilai tingkat kesiapan empati diri Anda saat menghadapi situasi sosial tersebut?',
                        'options' => [
                            ['label' => 'A', 'option' => 'Sangat siap dan bersedia membantu korban perundungan', 'is_correct' => true],
                            ['label' => 'B', 'option' => 'Ragu-ragu untuk bertindak karena takut ikut dimusuhi', 'is_correct' => false],
                            ['label' => 'C', 'option' => 'Lebih memilih diam dan tidak memedulikan keadaan korban', 'is_correct' => false],
                            ['label' => 'D', 'option' => 'Menunggu orang lain bertindak terlebih dahulu', 'is_correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Bagian 3: Komitmen - Apa komitmen utama yang Anda ambil untuk menciptakan budaya empati di kelas?',
                        'options' => [
                            ['label' => 'A', 'option' => 'Selalu menyapa, mendukung, dan membela teman yang dikucilkan di sekolah', 'is_correct' => true],
                            ['label' => 'B', 'option' => 'Hanya berteman dengan orang-orang yang populer saja', 'is_correct' => false],
                            ['label' => 'C', 'option' => 'Berjanji tidak akan melaporkan pelaku demi menjaga solidaritas geng', 'is_correct' => false],
                            ['label' => 'D', 'option' => 'Menjauhi semua teman agar tidak terseret masalah', 'is_correct' => false],
                        ],
                    ],
                ];

                foreach ($sampleQuestions as $qi => $sq) {
                    $question = Question::create([
                        'assessment_id' => $assessment->id,
                        'question' => $sq['question'],
                        'type' => 'multiple_choice',
                        'score' => 1,
                        'urutan' => $qi + 1,
                    ]);

                    foreach ($sq['options'] as $opt) {
                        QuestionOption::create([
                            'question_id' => $question->id,
                            'label' => $opt['label'],
                            'option' => $opt['option'],
                            'is_correct' => $opt['is_correct'],
                        ]);
                    }
                }
            }
        }

        $this->call([
            CertificateTemplateSeeder::class,
            Topik1AssessmentSeeder::class,
            FinalCommitmentSeeder::class,
        ]);
    }
}
