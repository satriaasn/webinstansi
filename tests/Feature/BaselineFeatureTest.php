<?php

namespace Tests\Feature;

use Tests\TestCase;

class BaselineFeatureTest extends TestCase
{
    public function test_homepage_returns_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_contact_page_returns_successful_response(): void
    {
        $response = $this->get('/contact');
        $response->assertStatus(200);
    }

    public function test_login_page_returns_successful_response(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_dashboard_redirects_unauthenticated_user(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_api_berita_returns_successful_json_with_valid_key(): void
    {
        $response = $this->getJson('/api/berita?key=PemprovLampung');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'current_page', 'total']);
    }

    public function test_api_berita_rejects_without_key(): void
    {
        $response = $this->getJson('/api/berita');
        $response->assertStatus(403);
    }

    public function test_api_dishub_flight_schedules_with_valid_token(): void
    {
        $response = $this->withHeaders([
            'x-api-token-dishub' => env('API_TOKEN_DISHUB', 'dishub-api-2026'),
        ])->getJson('http://dishub.lampungprov.go.id/api/dishub/flight-schedules');

        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'data']);
    }

    public function test_api_dishub_rejects_without_token(): void
    {
        $response = $this->getJson('http://dishub.lampungprov.go.id/api/dishub/flight-schedules');
        $response->assertStatus(401);
    }

    public function test_api_informasi_sosial_layanan_with_valid_token_and_host(): void
    {
        $response = $this->withHeaders([
            'x-api-token-dinsos' => env('API_TOKEN_DINSOS', 'dinsos-api-2024'),
        ])->getJson('http://dinsos.lampungprov.go.id/api/informasi-sosial/layanan');

        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'data']);
    }

    public function test_api_informasi_sosial_rejects_without_token(): void
    {
        $response = $this->getJson('http://dinsos.lampungprov.go.id/api/informasi-sosial/layanan');
        $response->assertStatus(401);
    }

    public function test_call_file_blocks_env_access(): void
    {
        $response = $this->get('/call-file/.env');
        $this->assertTrue(in_array($response->status(), [403, 404]));
    }

    public function test_call_file_blocks_path_traversal(): void
    {
        $response = $this->get('/call-file/../.env');
        $this->assertTrue(in_array($response->status(), [403, 404]));
    }

    public function test_call_file_serves_valid_assets(): void
    {
        $response = $this->get('/call-file/assets/backend/css/bracket.css');
        $response->assertStatus(200);
        $this->assertStringContainsString('text/css', $response->headers->get('Content-Type'));
    }
}
