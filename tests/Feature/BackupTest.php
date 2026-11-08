<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class BackupTest extends TestCase
{
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );
    }

    public function test_guest_cannot_access_backup_page(): void
    {
        $response = $this->get('/dashboard/backup');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_backup_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/dashboard/backup');
        $response->assertStatus(200);
        $response->assertSee('Backup Database &amp; Storage', false);
        $response->assertSee('Ekspor &amp; Impor Database', false);
        $response->assertSee('Backup &amp; Impor Storage Public', false);
    }

    public function test_admin_can_export_database_sql(): void
    {
        $response = $this->actingAs($this->admin)->get('/dashboard/backup/export');
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/sql; charset=UTF-8');
    }

    public function test_admin_can_export_public_storage_zip(): void
    {
        $response = $this->actingAs($this->admin)->get('/dashboard/backup/storage-public');
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/zip');
    }
}
