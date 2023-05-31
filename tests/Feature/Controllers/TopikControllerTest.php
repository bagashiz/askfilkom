<?php

namespace Tests\Feature\Controllers;

use App\Models\Topik;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TopikControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_create_topik_by_admin tests when an admin user creates a new topik
     *
     * @return void
     */
    public function test_create_topik_by_admin(): void
    {
        // Create an admin user and authenticate
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);
        $this->actingAs($admin);

        // Create a new topik
        $response = $this->post('/topik', [
            'nama' => 'Topik Baru',
        ]);

        // Assert redirect to /topik
        $response->assertStatus(302)
            ->assertRedirect('/topik')
            ->assertSessionHas('success', 'Topik berhasil dibuat!');

        // Assert topik is created
        $this->assertDatabaseHas('topik', [
            'nama' => 'Topik Baru',
        ]);
    }

    /**
     * test_create_topik_by_non_admin tests when a non-admin user tries to create a new topik
     *
     * @return void
     */
    public function test_create_topik_by_non_admin(): void
    {
        // Create a non-admin user and authenticate
        $user = User::factory()->create([
            'is_admin' => false,
        ]);
        $this->actingAs($user);

        // Create a new topik
        $response = $this->post('/topik', [
            'nama' => 'Topik Baru',
        ]);

        // Assert forbidden
        $response->assertStatus(403);

        // Assert topik is not created
        $this->assertDatabaseMissing('topik', [
            'nama' => 'Topik Baru',
        ]);
    }

    /**
     * test_edit_topik_by_admin tests when an admin user edits a topik
     *
     * @return void
     */
    public function test_edit_topik_by_admin(): void
    {
        // Create an admin user and authenticate
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);
        $this->actingAs($admin);

        // Create a new topik
        $topik = Topik::factory()->create([
            'nama' => 'Topik Lama',
        ]);

        // Edit the topik
        $response = $this->patch('/topik/' . $topik->id_topik, [
            'nama' => 'Topik Baru',
        ]);

        // Assert redirect to /topik
        $response->assertStatus(302)
            ->assertRedirect('/topik')
            ->assertSessionHas('success', 'Topik berhasil diperbarui!');

        // Assert topik is updated
        $this->assertDatabaseHas('topik', [
            'nama' => 'Topik Baru',
        ]);
    }

    /**
     * test_edit_topik_by_non_admin tests when a non-admin user tries to edit a topik
     *
     * @return void
     */
    public function test_edit_topik_by_non_admin(): void
    {
        // Create a non-admin user and authenticate
        $user = User::factory()->create([
            'is_admin' => false,
        ]);
        $this->actingAs($user);

        // Create a new topik
        $topik = Topik::factory()->create([
            'nama' => 'Topik Lama',
        ]);

        // Edit the topik
        $response = $this->patch('/topik/' . $topik->id_topik, [
            'nama' => 'Topik Baru',
        ]);

        // Assert forbidden
        $response->assertStatus(403);

        // Assert topik is not updated
        $this->assertDatabaseMissing('topik', [
            'nama' => 'Topik Baru',
        ]);
    }

    /**
     * test_delete_topik_by_admin tests when an admin user deletes a topik
     *
     * @return void
     */
    public function test_delete_topik_by_admin(): void
    {
        // Create an admin user and authenticate
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);
        $this->actingAs($admin);

        // Create a new topik
        $topik = Topik::factory()->create([
            'nama' => 'Topik Lama',
        ]);

        // Delete the topik
        $response = $this->delete('/topik/' . $topik->id_topik);

        // Assert redirect to /topik
        $response->assertStatus(302)
            ->assertRedirect('/topik')
            ->assertSessionHas('success', 'Topik berhasil dihapus!');

        // Assert topik is deleted
        $this->assertDatabaseMissing('topik', [
            'nama' => 'Topik Lama',
        ]);
    }

    /**
     * test_delete_topik_by_non_admin tests when a non-admin user tries to delete a topik
     *
     * @return void
     */
    public function test_delete_topik_by_non_admin(): void
    {
        // Create a non-admin user and authenticate
        $user = User::factory()->create([
            'is_admin' => false,
        ]);
        $this->actingAs($user);

        // Create a new topik
        $topik = Topik::factory()->create([
            'nama' => 'Topik Lama',
        ]);

        // Delete the topik
        $response = $this->delete('/topik/' . $topik->id_topik);

        // Assert forbidden
        $response->assertStatus(403);

        // Assert topik is not deleted
        $this->assertDatabaseHas('topik', [
            'nama' => 'Topik Lama',
        ]);
    }
}
