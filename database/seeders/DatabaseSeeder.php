<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\Discussion;
use App\Models\DiscussionReply;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Registration;
use App\Models\TrainingModule;
use App\Models\TrainingTrack;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with comprehensive PKM AI training materials.
     */
    public function run(): void
    {
        // 1. Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@pkm-ai.ac.id'],
            [
                'name' => 'Prof. Dr. Ir. Administrator PKM',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'institution' => 'Pusat Riset Kecerdasan Artifisial & Sistem Cerdas',
                'phone' => '081234567890',
                'bio' => 'Koordinator Utama Pelatihan PKM Artificial Intelligence & Sistem Terdistribusi.',
            ]
        );

        $instructor = User::firstOrCreate(
            ['email' => 'instruktur@pkm-ai.ac.id'],
            [
                'name' => 'Dr. Eng. Rian Pratama, M.Kom.',
                'password' => Hash::make('password'),
                'role' => 'instructor',
                'institution' => 'Laboratorium Komputasi Terdistribusi & DSS',
                'phone' => '081298765432',
                'bio' => 'Peneliti spesialisasi Multi-Criteria Decision Making (MCDM) dan Distributed Deep Learning.',
            ]
        );

        $student = User::firstOrCreate(
            ['email' => 'peserta@pkm-ai.ac.id'],
            [
                'name' => 'Ahmad Fauzan',
                'password' => Hash::make('password'),
                'role' => 'participant',
                'institution' => 'Universitas Indonesia Mandiri',
                'phone' => '085711223344',
                'bio' => 'Peserta Pelatihan PKM AI Batch 2026.',
            ]
        );

        // 2. Track 1: AI untuk Sistem Pendukung Keputusan
        $trackSpk = TrainingTrack::firstOrCreate(
            ['slug' => 'ai-sistem-pendukung-keputusan'],
            [
                'title' => 'Artificial Intelligence untuk Sistem Pendukung Keputusan (SPK/DSS)',
                'description' => 'Mempelajari metodologi kecerdasan buatan dalam merancang decision support system, analisis multi-kriteria (SAW, TOPSIS, WP), hingga integrasi predictive machine learning untuk rekomendasi kebijakan strategis.',
                'icon' => 'brain',
                'level' => 'Pemula - Lanjutan',
                'duration_hours' => 18,
                'instructor_name' => 'Dr. Eng. Rian Pratama, M.Kom.',
                'instructor_title' => 'Associate Professor in Intelligent Systems',
                'is_active' => true,
            ]
        );

        // Track 1 Modules
        $spkModules = [
            [
                'title' => 'Modul 1: Fondasi AI dalam Sistem Pendukung Keputusan Modern',
                'slug' => 'fondasi-ai-dss-modern',
                'summary' => 'Memahami pergeseran dari DSS berbasis aturan konvensional menuju Decision Intelligence berbasis Machine Learning dan Multi-Criteria Decision Making (MCDM).',
                'content' => '<h3>1. Pengantar Decision Support Systems (DSS)</h3><p>Sistem Pendukung Keputusan (SPK) adalah sistem informasi interaktif yang menyediakan informasi, pemodelan, dan manipulasi data untuk membantu pengambilan keputusan dalam situasi yang semi-terstruktur dan tidak terstruktur.</p><h3>2. Peran AI dalam SPK Generasi Baru</h3><p>Dengan hadirnya Artificial Intelligence, SPK tidak lagi hanya mengandalkan aturan statis (if-then), melainkan mampu:</p><ul><li>Mengekstraksi fitur prediktif dari data historis menggunakan regresi dan klasifikasi ensemble.</li><li>Menyelesaikan permasalahan optimasi multi-objektif dengan multi-criteria evaluation.</li><li>Menyajikan rekomendasi yang dapat dijelaskan (Explainable AI / XAI) kepada pengambil keputusan.</li></ul>',
                'key_takeaways' => [
                    'Definisi & evolusi DSS dari era 1.0 hingga era AI 4.0',
                    'Komponen inti SPK: Manajemen Data, Model Base, Knowledge Base, dan Dialog Interface',
                    'Konvergensi Machine Learning dan metode Multi-Attribute Decision Making',
                ],
                'duration_minutes' => 45,
                'order_number' => 1,
                'resource_type' => 'article',
                'resource_url' => 'https://docs.pkm-ai.ac.id/modul/spk-1.pdf',
            ],
            [
                'title' => 'Modul 2: Metode Simple Additive Weighting (SAW) & Normalisasi Matriks',
                'slug' => 'metode-saw-normalisasi-matriks',
                'summary' => 'Algoritma SAW untuk pembobotan kriteria benefit dan cost secara aditif, perhitungan matriks keputusan ternormalisasi R, dan perankingan preferensi V.',
                'content' => '<h3>1. Konsep Dasar Simple Additive Weighting (SAW)</h3><p>Metode SAW sering juga dikenal dengan istilah metode penjumlahan berbobot. Konsep dasar metode SAW adalah mencari penjumlahan terbobot dari rating kinerja pada setiap alternatif pada semua atribut.</p><h3>2. Formula Normalisasi</h3><p>Untuk kriteria keuntungan (Benefit):</p><code>r_ij = x_ij / max(x_ij)</code><p>Untuk kriteria biaya (Cost):</p><code>r_ij = min(x_ij) / x_ij</code><h3>3. Nilai Preferensi Akhir</h3><code>V_i = Sum(w_j * r_ij)</code>',
                'key_takeaways' => [
                    'Perbedaan kriteria tipe Benefit (keuntungan) dan Cost (biaya)',
                    'Matriks keputusan berdimensi m x n',
                    'Perhitungan nilai preferensi komparatif',
                ],
                'duration_minutes' => 60,
                'order_number' => 2,
                'resource_type' => 'hands_on',
                'resource_url' => 'https://docs.pkm-ai.ac.id/modul/spk-saw.pdf',
            ],
            [
                'title' => 'Modul 3: Metode TOPSIS (Technique for Order Preference by Similarity to Ideal Solution)',
                'slug' => 'metode-topsis-solusi-ideal',
                'summary' => 'Prinsip geometris TOPSIS: memilih alternatif dengan jarak Euclidean terdekat dari Solusi Ideal Positif (A+) dan terjauh dari Solusi Ideal Negatif (A-).',
                'content' => '<h3>1. Geometri Ruang Keputusan TOPSIS</h3><p>TOPSIS didasarkan pada konsep bahwa alternatif terpilih yang terbaik tidak hanya memiliki jarak terpendek dari solusi ideal positif, namun juga memiliki jarak terjauh dari solusi ideal negatif.</p><h3>2. Langkah-Langkah Komputasi:</h3><ol><li>Membangun matriks keputusan yang ternormalisasi vektor.</li><li>Membangun matriks keputusan ternormalisasi terbobot.</li><li>Menentukan solusi ideal positif (A+) dan solusi ideal negatif (A-).</li><li>Menghitung jarak Euclidean D+ dan D-.</li><li>Menghitung kedekatan relatif setiap alternatif terhadap solusi ideal C_i = D- / (D- + D+).</li></ol>',
                'key_takeaways' => [
                    'Normalisasi Euclidean vector pada TOPSIS',
                    'Identifikasi titik batas A+ (positif) dan A- (negatif)',
                    'Perhitungan nilai kedekatan relatif C_i bernilai antara 0 hingga 1',
                ],
                'duration_minutes' => 75,
                'order_number' => 3,
                'resource_type' => 'hands_on',
                'resource_url' => 'https://docs.pkm-ai.ac.id/modul/spk-topsis.pdf',
            ],
            [
                'title' => 'Modul 4: Metode Weighted Product (WP) & Pemodelan Multi-Kriteria Eksponensial',
                'slug' => 'metode-weighted-product-wp',
                'summary' => 'Pendekatan perkalian berpangkat untuk menghubungkan rating atribut, di mana bobot kriteria berfungsi sebagai pangkat positif untuk benefit dan negatif untuk cost.',
                'content' => '<h3>1. Karakteristik Weighted Product</h3><p>Metode Weighted Product (WP) menggunakan perkalian untuk menghubungkan rating atribut, di mana rating setiap atribut harus dipangkatkan dulu dengan bobot atribut yang bersangkutan.</p><h3>2. Normalisasi Bobot</h3><code>w_j = W_j / Sum(W_j)</code><p>Di mana sum(w_j) = 1.</p><h3>3. Nilai Vektor S dan Vektor V</h3><code>S_i = Product(x_ij ^ w_j)</code><p>Vektor V yang merupakan nilai preferensi relatif alternatif:</p><code>V_i = S_i / Sum(S_k)</code>',
                'key_takeaways' => [
                    'Sifat komputasi non-linear eksponensial metode WP',
                    'Normalisasi bobot kriteria agar total pembobotan sama dengan satu',
                    'Interpretasi Vektor S dan Vektor V dalam keputusan ranking',
                ],
                'duration_minutes' => 50,
                'order_number' => 4,
                'resource_type' => 'article',
                'resource_url' => 'https://docs.pkm-ai.ac.id/modul/spk-wp.pdf',
            ],
            [
                'title' => 'Modul 5: Studi Kasus Real-World: Seleksi Arsitektur Komputasi AI Skala Besar',
                'slug' => 'studi-kasus-seleksi-arsitektur-ai',
                'summary' => 'Praktik langsung menguji dataset pemilihan infrastruktur klaster AI server menggunakan gabungan metode SAW, TOPSIS, dan WP.',
                'content' => '<h3>1. Latar Belakang Masalah</h3><p>Organisasi enterprise membutuhkan penentuan arsitektur terbaik untuk model inferensi AI, dengan pertimbangan throughput (C1), latency (C2), operational cost (C3), fault tolerance (C4), dan scalability (C5).</p><h3>2. Hands-on Lab</h3><p>Gunakan simulator SPK interaktif yang tersedia di menu Laboratorium AI untuk memasukkan dataset, mengubah bobot secara dinamis, dan menganalisis sensitivitas peringkat alternatif.</p>',
                'key_takeaways' => [
                    'Penyusunan matriks kriteria berbasis parameter SLA enterprise',
                    'Analisis sensitivitas perubahan bobot kriteria',
                    'Validasi silang antar metode SAW, TOPSIS, dan WP',
                ],
                'duration_minutes' => 90,
                'order_number' => 5,
                'resource_type' => 'case_study',
                'resource_url' => 'https://docs.pkm-ai.ac.id/modul/studi-kasus-spk.pdf',
            ],
        ];

        foreach ($spkModules as $m) {
            TrainingModule::firstOrCreate(
                ['slug' => $m['slug']],
                array_merge($m, ['training_track_id' => $trackSpk->id])
            );
        }

        // Quiz for Track 1
        $quizSpk = Quiz::firstOrCreate(
            ['slug' => 'evaluasi-kompetensi-ai-spk'],
            [
                'training_track_id' => $trackSpk->id,
                'title' => 'Ujian Evaluasi Kompetensi: AI untuk Sistem Pendukung Keputusan',
                'description' => 'Tes evaluasi pemahaman teori, formula matematis, dan penerapan algoritma SAW, TOPSIS, serta konsep dasar AI DSS.',
                'time_limit_minutes' => 20,
                'passing_score' => 70,
                'is_active' => true,
            ]
        );

        $spkQuestions = [
            [
                'question_text' => 'Pada metode Simple Additive Weighting (SAW), bagaimanakah rumus normalisasi nilai kriteria yang bertipe Biaya (Cost)?',
                'option_a' => 'r_ij = x_ij / max(x_ij)',
                'option_b' => 'r_ij = min(x_ij) / x_ij',
                'option_c' => 'r_ij = x_ij - min(x_ij)',
                'option_d' => 'r_ij = (x_ij)^2 / sum(x_ij)',
                'correct_answer' => 'B',
                'explanation' => 'Untuk kriteria tipe Cost pada metode SAW, rumus normalisasi adalah nilai minimum atribut dibagi dengan nilai alternatif bersangkutan (min(x_ij) / x_ij), sehingga nilai terkecil mendapatkan skor normalisasi tertinggi (1.0).',
                'order_number' => 1,
            ],
            [
                'question_text' => 'Konsep utama yang menjadi dasar dalam metode TOPSIS (Technique for Order Preference by Similarity to Ideal Solution) adalah...',
                'option_a' => 'Alternatif terbaik hanya berdasarkan biaya terendah.',
                'option_b' => 'Alternatif terbaik memiliki jarak terpendek dari solusi ideal positif (A+) dan jarak terjauh dari solusi ideal negatif (A-).',
                'option_c' => 'Alternatif ditentukan dengan pohon keputusan biner acak.',
                'option_d' => 'Menggunakan probabilitas Bayesian tanpa pembobotan matriks.',
                'correct_answer' => 'B',
                'explanation' => 'TOPSIS menggunakan prinsip jarak Euclidean geometris: solusi optimal memiliki kedekatan relatif terbesar terhadap solusi ideal positif dan sekaligus paling jauh dari solusi ideal negatif.',
                'order_number' => 2,
            ],
            [
                'question_text' => 'Pada metode Weighted Product (WP), bagaimana perlakuan terhadap bobot kriteria w_j untuk kriteria yang bertipe Biaya (Cost)?',
                'option_a' => 'Dipangkatkan dengan nilai positif w_j.',
                'option_b' => 'Dipangkatkan dengan nilai negatif (-w_j).',
                'option_c' => 'Dikalikan dengan konstanta nol.',
                'option_d' => 'Dieliminasi dari perkalian vektor S.',
                'correct_answer' => 'B',
                'explanation' => 'Pada metode WP, kriteria bertipe benefit dipangkatkan dengan bobot positif (+w_j), sedangkan kriteria bertipe cost dipangkatkan dengan bobot negatif (-w_j) agar nilai alternatif yang besar menghasilkan nilai produk yang lebih kecil.',
                'order_number' => 3,
            ],
            [
                'question_text' => 'Mengapa integrasi Machine Learning (ML) penting dalam Sistem Pendukung Keputusan (SPK) generasi modern?',
                'option_a' => 'Karena ML mampu mengekstraksi pola non-linier dan memberikan prediksi probabilitas otomatis dari data historis.',
                'option_b' => 'Karena ML menggantikan manusia sepenuhnya sehingga keputusan tidak perlu dipertanggungjawabkan.',
                'option_c' => 'Karena rumus matematika konvensional sudah tidak berlaku di komputer modern.',
                'option_d' => 'Karena ML hanya bekerja jika tidak ada data sama sekali.',
                'correct_answer' => 'A',
                'explanation' => 'AI/ML memperkaya DSS dengan kemampuan prediksi berbasis data historis (Predictive DSS) dan rekomendasi adaptif, yang kemudian diranking dengan Multi-Criteria Decision Analysis.',
                'order_number' => 4,
            ],
            [
                'question_text' => 'Rentang nilai preferensi kedekatan relatif (C_i) pada metode TOPSIS berada pada rentang:',
                'option_a' => '-1 sampai +1',
                'option_b' => '0 sampai 100',
                'option_c' => '0 sampai 1',
                'option_d' => '1 sampai tak hingga',
                'correct_answer' => 'C',
                'explanation' => 'Nilai C_i dihitung dengan formula D- / (D- + D+). Karena nilai jarak D+ dan D- selalu non-negatif, maka rasio C_i selalu berada dalam rentang [0, 1]. Nilai mendekati 1 menunjukkan alternatif yang sangat mendekati ideal positif.',
                'order_number' => 5,
            ],
        ];

        foreach ($spkQuestions as $q) {
            Question::firstOrCreate(
                ['quiz_id' => $quizSpk->id, 'order_number' => $q['order_number']],
                array_merge($q, ['quiz_id' => $quizSpk->id])
            );
        }

        // 3. Track 2: Sistem Terdistribusi untuk AI
        $trackDist = TrainingTrack::firstOrCreate(
            ['slug' => 'sistem-terdistribusi-komputasi-ai'],
            [
                'title' => 'Arsitektur Sistem Terdistribusi untuk Komputasi AI Skala Besar',
                'description' => 'Mempelajari prinsip dasar distributed systems, teorema CAP, load balancing cluster, konsensus Raft, sinkronisasi node inferensi, hingga arsitektur fault-tolerant pada klaster AI terdistribusi.',
                'icon' => 'network',
                'level' => 'Menengah - Lanjutan',
                'duration_hours' => 20,
                'instructor_name' => 'Dr. Eng. Rian Pratama, M.Kom.',
                'instructor_title' => 'Cloud & Distributed Systems Specialist',
                'is_active' => true,
            ]
        );

        $distModules = [
            [
                'title' => 'Modul 1: Pengantar Sistem Terdistribusi & Tantangan Komputasi AI',
                'slug' => 'pengantar-sistem-terdistribusi-ai',
                'summary' => 'Konsep fundamental distributed systems: transparansi, konkurensi, heterogenitas, dan keterbatasan komputasi single-node untuk model AI modern.',
                'content' => '<h3>1. Mengapa AI Membutuhkan Sistem Terdistribusi?</h3><p>Model AI modern seperti Large Language Models (LLM) berukuran puluhan hingga ratusan miliar parameter tidak dapat dimuat ke dalam memori VRAM satu GPU tunggal. Sistem terdistribusi memungkinkan pemecahan model (sharding) dan paralelisme data di berbagai node.</p><h3>2. Karakteristik Sistem Terdistribusi:</h3><ul><li>Tidak ada memori bersama (shared nothing architecture).</li><li>Keterlambatan jaringan (network latency) dan partisi jaringan.</li><li>Kegagalan independen (partial failure): satu node dapat crash tanpa menghentikan seluruh sistem.</li></ul>',
                'key_takeaways' => [
                    'Arsitektur Shared-Nothing versus Shared-Memory',
                    'Alasan fundamental distribusi beban inferensi dan training AI',
                    'Fallacies of Distributed Computing (asumsi keliru dalam jaringan)',
                ],
                'duration_minutes' => 50,
                'order_number' => 1,
                'resource_type' => 'article',
                'resource_url' => 'https://docs.pkm-ai.ac.id/modul/dist-1.pdf',
            ],
            [
                'title' => 'Modul 2: Teorema CAP & Model Konsistensi Data',
                'slug' => 'teorema-cap-konsistensi-data',
                'summary' => 'Analisis mendalam mengenai pertukaran antara Consistency, Availability, dan Partition Tolerance (CAP Theorem) serta Eventual Consistency pada klaster.',
                'content' => '<h3>1. Teorema CAP (Brewer’s Conjecture)</h3><p>Dalam sistem terdistribusi asynchronous dengan partisi jaringan (P), kita hanya dapat memilih antara:</p><ul><li><strong>CP (Consistency + Partition Tolerance):</strong> Menolak request jika data belum tersinkronisasi sempurna demi memastikan kebenaran data.</li><li><strong>AP (Availability + Partition Tolerance):</strong> Menerima semua request meskipun beberapa node mungkin mengembalikan data lama (stale data).</li></ul><h3>2. Implikasi pada Cache AI dan Model Weights</h3><p>Untuk pembaruan bobot inferensi AI, eventual consistency sering kali cukup memadai demi mempertahankan availability dan throughput tinggi.</p>',
                'key_takeaways' => [
                    'Trade-off matematis dan praktis dalam teorema CAP',
                    'Perbedaan Strong Consistency vs Eventual Consistency',
                    'Pemilihan paradigma CP vs AP untuk pipeline machine learning',
                ],
                'duration_minutes' => 60,
                'order_number' => 2,
                'resource_type' => 'article',
                'resource_url' => 'https://docs.pkm-ai.ac.id/modul/dist-cap.pdf',
            ],
            [
                'title' => 'Modul 3: Load Balancing & High Availability (HA) pada AI Clusters',
                'slug' => 'load-balancing-ha-ai-cluster',
                'summary' => 'Strategi distribusi trafik inferensi: Round-Robin, Least Connections, Weighted Capacity, serta mekanisme Health Check dan Automatic Failover.',
                'content' => '<h3>1. Peran Reverse Proxy & Load Balancer</h3><p>Load balancer berada di depan klaster worker inferensi, bertugas merutekan ribuan request masuk secara adil agar tidak terjadi bottleneck pada salah satu GPU worker.</p><h3>2. Algoritma Routing:</h3><ul><li><strong>Round Robin:</strong> Merutekan secara bergiliran tanpa melihat kapasitas node.</li><li><strong>Least Connections:</strong> Merutekan ke node dengan jumlah koneksi aktif paling sedikit. Sangat cocok untuk inferensi AI yang durasi komputasinya bervariasi.</li><li><strong>Weighted Capacity:</strong> Memprioritaskan node dengan spesifikasi hardware lebih tinggi (misal: GPU H100 vs RTX 4090).</li></ul>',
                'key_takeaways' => [
                    'Algoritma distribusi beban kerja (Round Robin, Least Connections, Weighted)',
                    'Deteksi heartbeat dan penanganan graceful degradation',
                    'Arsitektur Zero-Downtime Deployment untuk model AI',
                ],
                'duration_minutes' => 65,
                'order_number' => 3,
                'resource_type' => 'hands_on',
                'resource_url' => 'https://docs.pkm-ai.ac.id/modul/dist-lb.pdf',
            ],
            [
                'title' => 'Modul 4: Algoritma Konsensus Terdistribusi (Raft & Paxos)',
                'slug' => 'algoritma-konsensus-raft-paxos',
                'summary' => 'Bagaimana klaster mencapai kesepakatan status bersama: Leader Election, Log Replication, Quorum, dan penanganan Split-Brain.',
                'content' => '<h3>1. Mengapa Konsensus Dibutuhkan?</h3><p>Ketika master node mengalami kegagalan, klaster harus secara otonom memilih pemimpin baru tanpa intervensi manual administrator untuk mencegah inkonsistensi koordinasi.</p><h3>2. Mekanisme Raft Consensus:</h3><ol><li><strong>Leader Election:</strong> Node memiliki 3 state: Leader, Candidate, Follower. Jika heartbeat leader hilang, election timer memicu voting.</li><li><strong>Log Replication:</strong> Semua perubahan status ditulis ke leader log terlebih dahulu sebelum disinkronkan ke mayoritas node (Quorum = N/2 + 1).</li><li><strong>Safety:</strong> Menjamin tidak ada dua leader sah dalam satu term yang sama.</li></ol>',
                'key_takeaways' => [
                    'Aturan Quorum mayoritas (N/2 + 1) untuk mencegah Split-Brain',
                    'Alur transisi state Follower -> Candidate -> Leader',
                    'Aplikasi Raft pada sistem produksi nyata (etcd, Kubernetes, Kafka KRaft)',
                ],
                'duration_minutes' => 80,
                'order_number' => 4,
                'resource_type' => 'article',
                'resource_url' => 'https://docs.pkm-ai.ac.id/modul/dist-raft.pdf',
            ],
            [
                'title' => 'Modul 5: Hands-on Lab: Simulasi Klaster AI Terdistribusi & Chaos Testing',
                'slug' => 'simulasi-klaster-ai-chaos-testing',
                'summary' => 'Praktikum interaktif mensimulasikan kegagalan node (crash), memonitor throughput RPS, mengamati failover Raft, dan mengukur degradasi latensi.',
                'content' => '<h3>1. Skenario Uji Klaster</h3><p>Peserta akan menjalankan simulator klaster terdistribusi 4-node GPU dengan variasi beban batch inferensi dan menyimulasikan kejadian crash pada Leader Node.</p><h3>2. Instruksi Praktik:</h3><p>Buka menu <strong>Simulator Klaster AI</strong>, pilih algoritma Least Connections, tetapkan 200 batch requests, dan matikan Node-1. Amati proses pemilihan leader baru dan pergeseran kurva beban kerja.</p>',
                'key_takeaways' => [
                    'Observabilitas metrik sistem terdistribusi (RPS, Latency p99, Drop Rate)',
                    'Simulasi Chaos Engineering dan observasi pemulihan klaster (failover)',
                    'Analisis dampak partisi jaringan terhadap kinerja AI inference',
                ],
                'duration_minutes' => 90,
                'order_number' => 5,
                'resource_type' => 'case_study',
                'resource_url' => 'https://docs.pkm-ai.ac.id/modul/lab-distributed.pdf',
            ],
        ];

        foreach ($distModules as $m) {
            TrainingModule::firstOrCreate(
                ['slug' => $m['slug']],
                array_merge($m, ['training_track_id' => $trackDist->id])
            );
        }

        // Quiz for Track 2
        $quizDist = Quiz::firstOrCreate(
            ['slug' => 'evaluasi-kompetensi-sistem-terdistribusi'],
            [
                'training_track_id' => $trackDist->id,
                'title' => 'Ujian Evaluasi Kompetensi: Arsitektur Sistem Terdistribusi untuk AI',
                'description' => 'Tes evaluasi pemahaman arsitektur sistem terdistribusi, teorema CAP, load balancing, konsensus Raft, dan fault tolerance.',
                'time_limit_minutes' => 20,
                'passing_score' => 70,
                'is_active' => true,
            ]
        );

        $distQuestions = [
            [
                'question_text' => 'Berdasarkan Teorema CAP (Brewer\'s Theorem), kondisi apa yang TIDAK BISA dihindari dalam jaringan fisik nyata sehingga sistem harus memilih antara C (Consistency) atau A (Availability)?',
                'option_a' => 'CPU Bottleneck',
                'option_b' => 'Partition Tolerance (P) atau kegagalan komunikasi jaringan',
                'option_c' => 'Kapasitas RAM server yang habis',
                'option_d' => 'Kesalahan penulisan kode sumber program',
                'correct_answer' => 'B',
                'explanation' => 'Jaringan komputer fisik di dunia nyata pasti berisiko mengalami packet drop, kabel terputus, atau latensi tak terduga (Network Partition). Oleh karena itu, arsitektur harus memilih mempertahankan konsistensi (CP) atau mempertahankan ketersediaan (AP) saat partisi terjadi.',
                'order_number' => 1,
            ],
            [
                'question_text' => 'Algoritma Load Balancing manakah yang paling ideal untuk beban kerja inferensi AI dengan ukuran prompt teks yang sangat bervariasi (komputasi GPU tidak seragam)?',
                'option_a' => 'Round Robin Statis',
                'option_b' => 'Random Selection',
                'option_c' => 'Least Connections (Koneksi Aktif Paling Sedikit)',
                'option_d' => 'First Come First Served pada single node',
                'correct_answer' => 'C',
                'explanation' => 'Karena durasi inferensi token bervariasi (prompt pendek selesai dalam 50ms, prompt panjang membutuhkan 500ms), Round Robin dapat menumpuk request berat di satu node. Least Connections secara dinamis merutekan request ke node yang sedang memproses beban paling sedikit.',
                'order_number' => 2,
            ],
            [
                'question_text' => 'Pada algoritma konsensus Raft dengan jumlah 5 node klaster, berapakah jumlah minimum node aktif (Quorum) yang dibutuhkan agar klaster tetap dapat memilih Leader baru dan menyetujui log transaksi?',
                'option_a' => '2 Node',
                'option_b' => '3 Node',
                'option_c' => '4 Node',
                'option_d' => '5 Node (Harus 100%)',
                'correct_answer' => 'B',
                'explanation' => 'Aturan Quorum mayoritas pada Raft adalah floor(N/2) + 1. Untuk N = 5, Quorum = (5/2) + 1 = 2.5 + 1 = 3 node. Artinya klaster dapat mentolerir kegagalan hingga 2 node sekaligus.',
                'order_number' => 3,
            ],
            [
                'question_text' => 'Apa yang dimaksud dengan kondisi Split-Brain pada sistem terdistribusi?',
                'option_a' => 'Ketika sistem menggunakan dua jenis GPU yang berbeda arsitektur.',
                'option_b' => 'Kondisi di mana partisi jaringan menyebabkan dua kelompok node sama-sama mengklaim diri sebagai Leader yang sah dan menerima mutasi data berbeda.',
                'option_c' => 'Kerusakan fisik pada motherboard server master.',
                'option_d' => 'Hilangnya seluruh data storage secara permanen.',
                'correct_answer' => 'B',
                'explanation' => 'Split-Brain terjadi saat partisi jaringan membelah klaster menjadi dua segmen terisolasi, dan kedua segmen memilih leader sendiri karena tidak memiliki mekanisme Quorum mayoritas yang ketat, menyebabkan inkonsistensi data yang parah.',
                'order_number' => 4,
            ],
            [
                'question_text' => 'Strategi apa yang digunakan dalam Distributed Deep Learning ketika ukuran model parameter AI melebihi kapasitas memori satu kartu grafis (GPU)?',
                'option_a' => 'Tensor Parallelism & Model Sharding (seperti Megatron-LM / DeepSpeed ZeRO)',
                'option_b' => 'Menghapus separuh dataset pelatihan',
                'option_c' => 'Menggunakan CPU 32-bit konvensional',
                'option_d' => 'Menonaktifkan backpropagation gradien',
                'correct_answer' => 'A',
                'explanation' => 'Jika model terlalu besar untuk satu GPU (misal model 70B parameter membutuhkan >140GB VRAM), arsitektur terdistribusi membagi lapisan model dan bobot tensor di beberapa GPU melalui Tensor/Pipeline Parallelism dan ZeRO sharding.',
                'order_number' => 5,
            ],
        ];

        foreach ($distQuestions as $q) {
            Question::firstOrCreate(
                ['quiz_id' => $quizDist->id, 'order_number' => $q['order_number']],
                array_merge($q, ['quiz_id' => $quizDist->id])
            );
        }

        // 4. Sample Registrations for Demo Student
        $regSpk = Registration::firstOrCreate(
            ['user_id' => $student->id, 'training_track_id' => $trackSpk->id],
            [
                'registration_code' => 'PKM-SPK-2026-001',
                'status' => 'approved',
                'attended' => true,
                'motivation_reason' => 'Ingin mendalami integrasi kecerdasan buatan pada sistem pendukung keputusan untuk riset tugas akhir.',
                'prior_experience' => 'Menengah',
            ]
        );

        $regDist = Registration::firstOrCreate(
            ['user_id' => $student->id, 'training_track_id' => $trackDist->id],
            [
                'registration_code' => 'PKM-DIST-2026-002',
                'status' => 'approved',
                'attended' => true,
                'motivation_reason' => 'Tertarik mempelajari arsitektur klaster inferensi AI skala enterprise dan failover system.',
                'prior_experience' => 'Pemula (Dasar)',
            ]
        );

        // 5. Sample Passed Quiz Attempt & Certificate for Demo Student on Track 1
        $attempt = QuizAttempt::firstOrCreate(
            ['user_id' => $student->id, 'quiz_id' => $quizSpk->id],
            [
                'score' => 100.0,
                'correct_count' => 5,
                'total_questions' => 5,
                'is_passed' => true,
                'answers_payload' => [1 => 'B', 2 => 'B', 3 => 'B', 4 => 'A', 5 => 'C'],
                'completed_at' => now()->subDays(2),
            ]
        );

        Certificate::firstOrCreate(
            ['user_id' => $student->id, 'training_track_id' => $trackSpk->id],
            [
                'certificate_number' => 'CERT/PKM-AI/SPK/2026/0089',
                'verify_code' => 'PKM-SPK-V9B71C',
                'quiz_attempt_id' => $attempt->id,
                'final_score' => 100.0,
                'issue_date' => now()->subDays(2)->toDateString(),
                'status' => 'valid',
            ]
        );

        // 6. Discussions & Replies
        $disc1 = Discussion::firstOrCreate(
            ['title' => 'Pertanyaan: Mengapa pada SAW nilai Cost harus dibalik perhitungannya?'],
            [
                'user_id' => $student->id,
                'training_track_id' => $trackSpk->id,
                'category' => 'SPK / DSS',
                'content' => 'Halo Bapak/Ibu Instruktur, mohon pencerahannya pada modul SAW. Mengapa pada kriteria biaya (cost) rumusnya min/x dan bukan sebaliknya seperti benefit? Terima kasih.',
                'is_resolved' => true,
                'views_count' => 24,
            ]
        );

        DiscussionReply::firstOrCreate(
            ['discussion_id' => $disc1->id, 'user_id' => $instructor->id],
            [
                'content' => 'Pertanyaan yang sangat bagus, Ahmad. Pada kriteria Biaya (Cost), semakin kecil nilainya maka semakin menguntungkan bagi pengambil keputusan. Dengan formula min(x)/x, alternatif dengan nilai biaya terkecil akan menghasilkan rasio 1.0 (nilai tertinggi), sedangkan biaya yang lebih besar akan menghasilkan nilai lebih rendah mendekati 0. Ini menstandarkan semua kriteria ke arah maksimasi preferensi.',
                'is_instructor_answer' => true,
            ]
        );

        $disc2 = Discussion::firstOrCreate(
            ['title' => 'Diskusi Praktik: Pengaruh Latensi Jaringan pada Leader Election Raft'],
            [
                'user_id' => $student->id,
                'training_track_id' => $trackDist->id,
                'category' => 'Sistem Terdistribusi',
                'content' => 'Bagaimana jika latensi jaringan antar node lebih lambat daripada election timeout pada algoritma Raft? Apakah klaster akan terus-menerus melakukan election?',
                'is_resolved' => true,
                'views_count' => 38,
            ]
        );

        DiscussionReply::firstOrCreate(
            ['discussion_id' => $disc2->id, 'user_id' => $instructor->id],
            [
                'content' => 'Tepat sekali! Fenomena ini dinamakan "flapping election". Jika broadcast heartbeat leader terlambat sampai ke followers karena congestion atau latency spike melebihi election timeout, follower akan menganggap leader mati dan memicu voting baru. Solusinya dalam arsitektur produksi adalah menetapkan BroadcastTime << ElectionTimeout << MTBF (Mean Time Between Failures).',
                'is_instructor_answer' => true,
            ]
        );
    }
}
