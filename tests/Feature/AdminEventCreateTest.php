<?php

namespace Tests\Feature;

use App\Models\EventCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminEventCreateTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $user = User::factory()->create()->assignRole('super-admin');

        $generationId = DB::table('generations')->insertGetId(['year' => '2024']);
        DB::table('members')->insert([
            'user_id' => $user->id,
            'generation_id' => $generationId,
            'full_name' => 'Admin',
            'npm' => '1234567890',
        ]);

        return $user;
    }

    public function test_failed_event_validation_is_shown_on_create_page(): void
    {
        $category = EventCategory::create(['name' => 'Raker', 'slug' => 'raker']);
        $periodId = DB::table('periods')->insertGetId(['cabinet_name' => 'Kabinet', 'period_range' => '2025/2026']);

        $this->withoutVite()
            ->actingAs($this->admin())
            ->from('/admin/events/create')
            ->followingRedirects()
            ->post('/admin/events', [
                'event_category_id' => $category->id,
                'period_id' => $periodId,
                'title' => 'Raker 2026',
                'short_description' => 'Rapat kerja',
                'description' => '{"blocks":[]}',
                'event_date' => '2026-10-10',
                'location' => 'Aula',
                'status' => 'upcoming',
            ])
            ->assertOk()
            ->assertSee('Event gagal disimpan')
            ->assertSee('Thumbnail wajib diunggah.')
            ->assertSee('value="2026-10-10"', false);

        $this->assertDatabaseCount('events', 0);
    }
}
