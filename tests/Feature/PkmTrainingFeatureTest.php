<?php

namespace Tests\Feature;

use App\Models\Certificate;
use App\Models\Quiz;
use App\Models\TrainingModule;
use App\Models\TrainingTrack;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PkmTrainingFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_homepage_loads_successfully(): void
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertSeeText('Pelatihan');
        $response->assertSeeText('Artificial Intelligence');
        $response->assertSeeText('Sistem Pendukung Keputusan');
    }

    public function test_tracks_index_and_show_page_loads(): void
    {
        $track = TrainingTrack::first();
        $this->assertNotNull($track);

        $response = $this->get(route('tracks.index'));
        $response->assertStatus(200);
        $response->assertSee($track->title);

        $responseDetail = $this->get(route('tracks.show', $track->slug));
        $responseDetail->assertStatus(200);
        $responseDetail->assertSee($track->title);
    }

    public function test_module_page_displays_content(): void
    {
        $module = TrainingModule::first();
        $this->assertNotNull($module);

        $response = $this->get(route('modules.show', [
            'trackSlug' => $module->track->slug,
            'moduleSlug' => $module->slug,
        ]));

        $response->assertStatus(200);
        $response->assertSee($module->title);
    }

    public function test_spk_lab_calculate_endpoint_returns_json(): void
    {
        $payload = [
            'method' => 'saw',
            'criteria' => [
                ['code' => 'C1', 'name' => 'Kriteria 1', 'weight' => 0.5, 'type' => 'benefit'],
                ['code' => 'C2', 'name' => 'Kriteria 2', 'weight' => 0.5, 'type' => 'cost'],
            ],
            'alternatives' => [
                ['code' => 'A1', 'name' => 'Alternatif 1', 'values' => ['C1' => 80, 'C2' => 20]],
                ['code' => 'A2', 'name' => 'Alternatif 2', 'values' => ['C1' => 60, 'C2' => 40]],
            ],
        ];

        $response = $this->postJson(route('labs.spk.calculate'), $payload);
        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonStructure(['result' => ['method', 'final_scores']]);
    }

    public function test_distributed_lab_simulate_endpoint_returns_json(): void
    {
        $payload = [
            'algorithm' => 'least_connections',
            'batch_requests' => 50,
            'concurrency' => 10,
            'failed_node' => '',
            'replication_factor' => 3,
        ];

        $response = $this->postJson(route('labs.distributed.simulate'), $payload);
        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonStructure(['result' => ['algorithm_used', 'nodes', 'metrics']]);
    }

    public function test_quick_login_works_for_roles(): void
    {
        $response = $this->get(route('quick-login', 'participant'));
        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();

        $responseAdmin = $this->get(route('quick-login', 'admin'));
        $responseAdmin->assertRedirect(route('home'));
        $this->assertEquals('admin', auth()->user()->role);
    }

    public function test_quiz_submission_grades_and_issues_certificate_when_passed(): void
    {
        $newStudent = User::factory()->create([
            'role' => 'participant',
            'name' => 'Peserta Baru Ujian',
            'institution' => 'Institut Teknologi AI',
        ]);

        $quiz = Quiz::with('questions')->first();
        $this->assertNotNull($quiz);

        // Prepare perfect answers
        $answers = [];
        foreach ($quiz->questions as $q) {
            $answers[$q->id] = $q->correct_answer;
        }

        $response = $this->actingAs($newStudent)->post(route('quiz.submit', $quiz->slug), [
            'answers' => $answers,
        ]);

        $response->assertRedirect();

        // Verify Certificate was created
        $cert = Certificate::where('user_id', $newStudent->id)
            ->where('training_track_id', $quiz->training_track_id)
            ->first();

        $this->assertNotNull($cert);
        $this->assertEquals('valid', $cert->status);
        $this->assertEquals(100.0, $cert->final_score);
        $this->assertStringStartsWith('CERT/PKM-AI/', $cert->certificate_number);
        $this->assertNotEmpty($cert->verify_code);
    }

    public function test_public_certificate_verification(): void
    {
        $cert = Certificate::first();
        $this->assertNotNull($cert);

        $response = $this->get(route('certificates.verify', ['code' => $cert->verify_code]));
        $response->assertStatus(200);
        $response->assertSee($cert->certificate_number);
        $response->assertSee('STATUS: VALID');
    }

    public function test_certificate_show_page_loads_with_slashed_certificate_number(): void
    {
        $cert = Certificate::first();
        $this->assertNotNull($cert);

        $response = $this->get(route('certificates.show', $cert->certificate_number));
        $response->assertStatus(200);
        $response->assertSee($cert->certificate_number);
        $response->assertSee($cert->user->name);
        $response->assertSeeText('SERTIFIKAT KELULUSAN');
    }

    public function test_sample_certificate_route_loads(): void
    {
        $response = $this->get(route('certificates.sample'));
        $response->assertStatus(200);
        $response->assertSeeText('SERTIFIKAT KELULUSAN');
        $response->assertSee('size: A4 landscape');
        $response->assertSee('cert-inner-content');
        $response->assertSee('cert-sec-signatures');
        $response->assertSee('Cetak / Unduh PDF (1 Halaman A4)');
    }

    public function test_certificates_index_loads_for_guest_and_user(): void
    {
        $responseGuest = $this->get(route('certificates.index'));
        $responseGuest->assertStatus(200);
        $responseGuest->assertSeeText('E-Sertifikat Digital Resmi PKM AI');

        $student = User::where('role', 'participant')->first();
        $responseUser = $this->actingAs($student)->get(route('certificates.index'));
        $responseUser->assertStatus(200);
        $responseUser->assertSeeText('Sertifikat Milik Saya');
    }
}
