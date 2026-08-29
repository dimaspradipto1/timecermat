<?php

namespace Tests\Feature;

use App\Models\Schools;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TimeCermatTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Ensure admin user exists
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );
    }

    public function test_beranda_screen_is_accessible(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('UIS Grand Academic Challenge');
    }

    public function test_stage_api_returns_json(): void
    {
        $response = $this->get('/api/stage-data');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'timer' => ['duration', 'remaining', 'status'],
            'slots' => [
                1 => ['name', 'score'],
                2 => ['name', 'score'],
                3 => ['name', 'score'],
            ]
        ]);
    }

    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Login ke Dashboard');
    }

    public function test_admin_can_login(): void
    {
        $response = $this->post('/login', [
            'login' => 'admin@gmail.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    public function test_admin_can_access_dashboard(): void
    {
        $admin = User::where('email', 'admin@gmail.com')->first();
        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Dashboard &amp; Kontrol Panggung', false);
    }

    public function test_schools_datatables_endpoint(): void
    {
        $admin = User::where('email', 'admin@gmail.com')->first();
        $response = $this->actingAs($admin)->getJson('/dashboard/schools', [
            'HTTP_X-Requested-With' => 'XMLHttpRequest'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_admin_can_create_update_and_delete_school(): void
    {
        $admin = User::where('email', 'admin@gmail.com')->first();

        // Create
        $response = $this->actingAs($admin)->post('/dashboard/schools', [
            'name' => 'SMA TEST UNIT',
            'regu' => 'Regu D',
            'score' => 50,
            'slot' => null,
        ]);
        $response->assertRedirect('/dashboard/schools');

        $school = Schools::where('name', 'SMA TEST UNIT')->first();
        $this->assertNotNull($school);
        $this->assertEquals(50, $school->score);

        // Quick adjust score
        $scoreResponse = $this->actingAs($admin)->postJson("/dashboard/schools/{$school->id}/adjust-score", [
            'action' => 'add',
            'amount' => 10,
        ]);
        $scoreResponse->assertJson(['success' => true, 'score' => 60]);

        // Delete
        $deleteResponse = $this->actingAs($admin)->deleteJson("/dashboard/schools/{$school->id}");
        $deleteResponse->assertJson(['success' => true]);
        $this->assertNull(Schools::find($school->id));
    }

    public function test_users_datatables_endpoint(): void
    {
        $admin = User::where('email', 'admin@gmail.com')->first();
        $response = $this->actingAs($admin)->getJson('/dashboard/users', [
            'HTTP_X-Requested-With' => 'XMLHttpRequest'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_admin_can_create_update_and_delete_user(): void
    {
        $admin = User::where('email', 'admin@gmail.com')->first();

        // Create
        $response = $this->actingAs($admin)->post('/dashboard/users', [
            'name' => 'Operator Test',
            'email' => 'operator@example.com',
            'password' => 'secret123',
            'role' => 'operator',
        ]);
        $response->assertRedirect('/dashboard/users');

        $createdUser = User::where('email', 'operator@example.com')->first();
        $this->assertNotNull($createdUser);
        $this->assertEquals('operator', $createdUser->role);

        // Update
        $updateResponse = $this->actingAs($admin)->putJson("/dashboard/users/{$createdUser->id}", [
            'name' => 'Operator Updated',
            'email' => 'operator@example.com',
            'role' => 'juri',
        ]);
        $updateResponse->assertJson(['success' => true]);

        // Delete
        $deleteResponse = $this->actingAs($admin)->deleteJson("/dashboard/users/{$createdUser->id}");
        $deleteResponse->assertJson(['success' => true]);
        $this->assertNull(User::find($createdUser->id));
    }

    public function test_timer_api_control(): void
    {
        $response = $this->postJson('/api/stage-timer', [
            'action' => 'set_duration',
            'duration' => 30,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'timer' => [
                'duration' => 30,
                'status' => 'stopped',
            ]
        ]);
    }
}
