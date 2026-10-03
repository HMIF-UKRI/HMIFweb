<?php

namespace Tests\Feature;

use App\Models\EventCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);

        return User::factory()->create()->assignRole('super-admin');
    }

    public function test_event_category_can_be_created(): void
    {
        $this->actingAs($this->admin())
            ->from('/admin/categories')
            ->post('/admin/categories', ['type' => 'event', 'name' => 'Workshop'])
            ->assertRedirect('/admin/categories')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('event_categories', ['name' => 'Workshop', 'slug' => 'workshop']);
    }

    public function test_duplicate_event_category_returns_validation_error(): void
    {
        EventCategory::create(['name' => 'Workshop', 'slug' => 'workshop']);

        $this->actingAs($this->admin())
            ->from('/admin/categories')
            ->post('/admin/categories', ['type' => 'event', 'name' => 'workshop'])
            ->assertRedirect('/admin/categories')
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('event_categories', 1);
    }

    public function test_event_category_name_longer_than_column_returns_validation_error(): void
    {
        $this->actingAs($this->admin())
            ->from('/admin/categories')
            ->post('/admin/categories', ['type' => 'event', 'name' => str_repeat('a', 51)])
            ->assertRedirect('/admin/categories')
            ->assertSessionHasErrors('name');
    }

    public function test_unknown_type_returns_validation_error(): void
    {
        $this->actingAs($this->admin())
            ->from('/admin/categories')
            ->post('/admin/categories', ['type' => 'unknown', 'name' => 'Workshop'])
            ->assertRedirect('/admin/categories')
            ->assertSessionHasErrors('type');
    }

    public function test_event_category_can_be_renamed_to_its_own_name(): void
    {
        EventCategory::create(['name' => 'Workshop', 'slug' => 'workshop']);

        $this->actingAs($this->admin())
            ->from('/admin/categories')
            ->patch('/admin/categories/workshop', ['type' => 'event', 'name' => 'Workshop'])
            ->assertRedirect('/admin/categories')
            ->assertSessionHasNoErrors();
    }

    public function test_validation_error_is_shown_on_categories_page(): void
    {
        EventCategory::create(['name' => 'Workshop', 'slug' => 'workshop']);

        $this->withoutVite()
            ->actingAs($this->admin())
            ->from('/admin/categories')
            ->followingRedirects()
            ->post('/admin/categories', ['type' => 'event', 'name' => 'Workshop'])
            ->assertOk()
            ->assertSee('Gagal menyimpan')
            ->assertSee('Kategori &#039;Workshop&#039; sudah ada.', false);
    }
}
