<?php

namespace Tests\Feature\Controllers;

use App\Models\Topik;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PertanyaanControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * test_create_pertanyaan_by_auth_user tests when authenticated user creates a pertanyaan
     * 
     * @return void
     */
    public function test_create_pertanyaan_by_auth_user(): void
    {
        // Create list of topik
        $topik = Topik::factory()->count(10)->create();

        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a pertanyaan
        $response = $this->post('/pertanyaan', [
            'judul' => $this->faker->sentence,
            'deskripsi' => $this->faker->paragraph,
            'topik' => $topik->random(2)->id_topik,
        ]);

        // Assert that the pertanyaan was created
        $this->assertDatabaseHas('pertanyaan', [
            'id_user' => $user->id_user,
            'judul' => $response['judul'],
            'deskripsi' => $response['deskripsi'],
        ]);

        // Assert that the user is redirected to the home page and sees the success message
        $response->assertStatus(302);
        $response->assertRedirect('/');
        $response->assertSessionHas('success', 'Pertanyaan berhasil dibuat!');
    }

    /**
     * test_create_pertanyaan_by_guest_user tests when guest user tries to create a pertanyaan
     * 
     * @return void
     */
    public function test_create_pertanyaan_by_guest_user(): void
    {
        // Create list of topik
        $topik = Topik::factory()->count(10)->create();

        // Create a pertanyaan
        $response = $this->post('/pertanyaan', [
            'judul' => $this->faker->sentence,
            'deskripsi' => $this->faker->paragraph,
            'topik' => $topik->random(2)->id_topik,
        ]);

        // Assert that the pertanyaan was not created
        $this->assertDatabaseMissing('pertanyaan', [
            'judul' => $response['judul'],
            'deskripsi' => $response['deskripsi'],
        ]);

        // Assert that the user is redirected to the login page
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * test_create_pertanyaan_with_invalid_data tests when authenticated user tries to create a pertanyaan with invalid data
     * 
     * @return void
     */
    public function test_create_pertanyaan_with_invalid_data(): void
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a pertanyaan
        $response = $this->post('/pertanyaan', [
            'judul' => '',
            'deskripsi' => '',
            'topik' => '',
        ]);

        // Assert that the pertanyaan was not created
        $this->assertDatabaseMissing('pertanyaan', [
            'judul' => $response['judul'],
            'deskripsi' => $response['deskripsi'],
        ]);

        // Assert that the user is redirected back to the create pertanyaan page and sees the error message
        $response->assertStatus(302);
        $response->assertRedirect('/pertanyaan/create');
        $response->assertSessionHasErrors(['judul', 'deskripsi', 'topik']);
    }

    /**
     * test_create_pertanyaan_with_invalid_topik tests when authenticated user tries to create a pertanyaan with invalid topik
     * 
     * @return void
     */
    public function test_create_pertanyaan_with_invalid_topik(): void
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create list of topik

        // Create a pertanyaan
        $response = $this->post('/pertanyaan', [
            'judul' => $this->faker->sentence,
            'deskripsi' => $this->faker->paragraph,
            'topik' => [9999, 9999],
        ]);

        // Assert that the pertanyaan was not created
        $this->assertDatabaseMissing('pertanyaan', [
            'judul' => $response['judul'],
            'deskripsi' => $response['deskripsi'],
        ]);

        // Assert that the user is redirected back to the create pertanyaan page and sees the error message
        $response->assertStatus(302);
        $response->assertRedirect('/pertanyaan/create');
        $response->assertSessionHasErrors(['topik']);
    }

    /**
     * test_update_pertanyaan_by_auth_user tests when authenticated user updates a pertanyaan
     * 
     * @return void
     */
    public function test_update_pertanyaan_by_auth_user(): void
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a list of topik
        $topik = Topik::factory()->count(10)->create();

        // Create a pertanyaan to be updated
        $pertanyaan = $user->pertanyaan()->create([
            'judul' => $this->faker->sentence,
            'deskripsi' => $this->faker->paragraph,
            'topik' => $topik->random(2)->id_topik,
        ]);

        // Update the pertanyaan
        $response = $this->patch('/pertanyaan/' . $pertanyaan->id_pertanyaan, [
            'judul' => 'Updated Judul',
            'deskripsi' => 'Updated Deskripsi',
            'topik' => $topik->random(2)->id_topik,
        ]);

        // Assert that the pertanyaan was updated
        $this->assertDatabaseHas('pertanyaan', [
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'id_user' => $user->id_user,
            'judul' => 'Updated Judul',
            'deskripsi' => 'Updated Deskripsi',
        ]);

        // Assert that the user is redirected to the home page and sees the success message
        $response->assertStatus(302);
        $response->assertRedirect('/');
        $response->assertSessionHas('success', 'Pertanyaan berhasil diperbarui!');
    }

    /**
     * test_update_pertanyaan_by_other_auth_user tests when authenticated user tries to update other user's pertanyaan
     * 
     * @return void
     */
    public function test_update_pertanyaan_by_other_auth_user(): void
    {
        // Create two users and authenticate the first user
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $this->actingAs($user1);

        // Create a list of topik
        $topik = Topik::factory()->count(10)->create();

        // Create a pertanyaan by the other user to be updated
        $pertanyaan = $user2->pertanyaan()->create([
            'judul' => $this->faker->sentence,
            'deskripsi' => $this->faker->paragraph,
            'topik' => $topik->random(2)->id_topik,
        ]);

        // Update the pertanyaan by authenticated user
        $response = $this->patch('/pertanyaan/' . $pertanyaan->id_pertanyaan, [
            'judul' => 'Updated Judul',
            'deskripsi' => 'Updated Deskripsi',
            'topik' => $topik->random(2)->id_topik,
        ]);

        // Assert that the updated pertanyaan is not found in the database
        $this->assertDatabaseMissing('pertanyaan', [
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'id_user' => $user1->id_user,
            'judul' => 'Updated Judul',
            'deskripsi' => 'Updated Deskripsi',
        ]);

        // Assert abort 403
        $response->assertStatus(403);
    }

    /**
     * test_update_pertanyaan_by_guest_user tests when guest user tries to update a pertanyaan
     * 
     * @return void
     */
    public function test_update_pertanyaan_by_guest_user(): void
    {
        // Create a user
        $user = User::factory()->create();

        // Create a list of topik
        $topik = Topik::factory()->count(10)->create();

        // Create a pertanyaan to be updated
        $pertanyaan = $user->pertanyaan()->create([
            'judul' => $this->faker->sentence,
            'deskripsi' => $this->faker->paragraph,
            'topik' => $topik->random(2)->id_topik,
        ]);

        // Update the pertanyaan
        $response = $this->patch('/pertanyaan/' . $pertanyaan->id_pertanyaan, [
            'judul' => 'Updated Judul',
            'deskripsi' => 'Updated Deskripsi',
            'topik' => $topik->random(2)->id_topik,
        ]);

        // Assert that the pertanyaan was not updated
        $this->assertDatabaseMissing('pertanyaan', [
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'judul' => 'Updated Judul',
            'deskripsi' => 'Updated Deskripsi',
        ]);

        // Assert that the user is redirected to the login page
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * test_update_pertanyaan_with_invalid_data tests when authenticated user tries to update a pertanyaan with invalid data
     * 
     * @return void
     */
    public function test_update_pertanyaan_with_invalid_data(): void
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a list of topik
        $topik = Topik::factory()->count(10)->create();

        // Create a pertanyaan to be updated
        $pertanyaan = $user->pertanyaan()->create([
            'judul' => $this->faker->sentence,
            'deskripsi' => $this->faker->paragraph,
            'topik' => $topik->random(2)->id_topik,
        ]);

        // Update the pertanyaan with invalid data
        $response = $this->patch('/pertanyaan/' . $pertanyaan->id_pertanyaan, [
            'judul' => '',
            'deskripsi' => '',
            'topik' => '',
        ]);

        // Assert that the pertanyaan was not updated
        $this->assertDatabaseMissing('pertanyaan', [
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'judul' => $response['judul'],
            'deskripsi' => $response['deskripsi'],
        ]);

        // Assert that the user is redirected back to the edit pertanyaan page and sees the error message
        $response->assertStatus(302);
        $response->assertRedirect('/pertanyaan/' . $pertanyaan->id_pertanyaan . '/edit');
        $response->assertSessionHasErrors(['judul', 'deskripsi', 'topik']);
    }

    /**
     * test_update_pertanyaan_with_invalid_topik tests when authenticated user tries to update a pertanyaan with invalid topik
     * 
     * @return void
     */
    public function test_update_pertanyaan_with_invalid_topik(): void
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a list of topik
        $topik = Topik::factory()->count(10)->create();

        // Create a pertanyaan to be updated
        $pertanyaan = $user->pertanyaan()->create([
            'judul' => $this->faker->sentence,
            'deskripsi' => $this->faker->paragraph,
            'topik' => $topik->random(2)->id_topik,
        ]);

        // Update the pertanyaan with invalid topik
        $response = $this->patch('/pertanyaan/' . $pertanyaan->id_pertanyaan, [
            'judul' => 'Updated Judul',
            'deskripsi' => 'Updated Deskripsi',
            'topik' => [999, 999]
        ]);

        // Assert that the pertanyaan was not updated
        $this->assertDatabaseMissing('pertanyaan', [
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'judul' => 'Updated Judul',
            'deskripsi' => 'Updated Deskripsi',
        ]);

        // Assert that the user is redirected back to the edit pertanyaan page and sees the error message
        $response->assertStatus(302);
        $response->assertRedirect('/pertanyaan/' . $pertanyaan->id_pertanyaan . '/edit');
        $response->assertSessionHasErrors(['topik']);
    }

    /**
     * test_delete_pertanyaan_by_authenticated_user tests when authenticated user tries to delete a pertanyaan
     * 
     * @return void
     */
    public function test_delete_pertanyaan_by_authenticated_user(): void
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a list of topik
        $topik = Topik::factory()->count(10)->create();

        // Create a pertanyaan to be deleted
        $pertanyaan = $user->pertanyaan()->create([
            'judul' => $this->faker->sentence,
            'deskripsi' => $this->faker->paragraph,
            'topik' => $topik->random(2)->id_topik,
        ]);

        // Delete the pertanyaan
        $response = $this->delete('/pertanyaan/' . $pertanyaan->id_pertanyaan);

        // Assert that the pertanyaan was deleted
        $this->assertDatabaseMissing('pertanyaan', [
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'judul' => $pertanyaan->judul,
            'deskripsi' => $pertanyaan->deskripsi,
        ]);

        // Assert that the user is redirected to the home page and sees the success message
        $response->assertStatus(302);
        $response->assertRedirect('/');
        $response->assertSessionHas('success', 'Pertanyaan berhasil dihapus!');
    }

    /**
     * test_delete_pertanyaan_by_other_auth_user tests when authenticated user tries to delete a pertanyaan created by other authenticated user
     * 
     * @return void
     */
    public function test_delete_pertanyaan_by_other_auth_user(): void
    {
        // Create two users and authenticate the first user
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $this->actingAs($user1);

        // Create a list of topik
        $topik = Topik::factory()->count(10)->create();

        // Create a pertanyaan by the second user
        $pertanyaan = $user2->pertanyaan()->create([
            'judul' => $this->faker->sentence,
            'deskripsi' => $this->faker->paragraph,
            'topik' => $topik->random(2)->id_topik,
        ]);

        // Delete the pertanyaan
        $response = $this->delete('/pertanyaan/' . $pertanyaan->id_pertanyaan);

        // Assert that the pertanyaan was not deleted
        $this->assertDatabaseHas('pertanyaan', [
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'judul' => $pertanyaan->judul,
            'deskripsi' => $pertanyaan->deskripsi,
        ]);

        // Assert abort 403
        $response->assertStatus(403);
    }

    /**
     * test_delete_pertanyaan_by_guest tests when guest tries to delete a pertanyaan
     * 
     * @return void
     */
    public function test_delete_pertanyaan_by_guest(): void
    {
        // Create a user
        $user = User::factory()->create();

        // Create a list of topik
        $topik = Topik::factory()->count(10)->create();

        // Create a pertanyaan to be deleted
        $pertanyaan = $user->pertanyaan()->create([
            'judul' => $this->faker->sentence,
            'deskripsi' => $this->faker->paragraph,
            'topik' => $topik->random(2)->id_topik,
        ]);

        // Delete the pertanyaan
        $response = $this->delete('/pertanyaan/' . $pertanyaan->id_pertanyaan);

        // Assert that the pertanyaan was not deleted
        $this->assertDatabaseHas('pertanyaan', [
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'judul' => $pertanyaan->judul,
            'deskripsi' => $pertanyaan->deskripsi,
        ]);

        // Assert redirect to login page
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * test_delete_pertanyaan_by_admin tests when admin tries to delete a pertanyaan
     * 
     * @return void
     */
    public function test_delete_pertanyaan_by_admin(): void
    {
        // Create an admin user and authenticate
        $user = User::factory()->create([
            'is_admin' => true,
        ]);
        $this->actingAs($user);

        // Create a user
        $user = User::factory()->create();

        // Create a list of topik
        $topik = Topik::factory()->count(10)->create();

        // Create a pertanyaan to be deleted
        $pertanyaan = $user->pertanyaan()->create([
            'judul' => $this->faker->sentence,
            'deskripsi' => $this->faker->paragraph,
            'topik' => $topik->random(2)->id_topik,
        ]);

        // Delete the pertanyaan
        $response = $this->delete('/pertanyaan/' . $pertanyaan->id_pertanyaan);

        // Assert that the pertanyaan was deleted
        $this->assertDatabaseMissing('pertanyaan', [
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'judul' => $pertanyaan->judul,
            'deskripsi' => $pertanyaan->deskripsi,
        ]);

        // Assert that the user is redirected to the home page and sees the success message
        $response->assertStatus(302);
        $response->assertRedirect('/');
        $response->assertSessionHas('success', 'Pertanyaan berhasil dihapus!');
    }
}
