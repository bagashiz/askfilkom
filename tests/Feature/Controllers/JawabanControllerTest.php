<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JawabanControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * test_create_jawaban_by_auth_user tests when authenticated user creates a jawaban
     *
     * @return void
     */
    public function test_create_jawaban_by_auth_user()
    {
        // Create authenticated user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create pertanyaan
        $pertanyaan = $user->pertanyaan()->create([
            'id_user' => $user->id_user,
            'judul' => $this->faker->text(60),
            'deskripsi' => $this->faker->text(1000),
        ]);

        // Create form data for jawaban
        $formData = [
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'deskripsi' => $this->faker->text(1000),
        ];

        // Create a jawaban
        $response = $this->post('/jawaban', $formData);

        // Assert that the user is redirected to the pertanyaan page
        $response->assertStatus(302)
            ->assertRedirect('/pertanyaan/' . $pertanyaan->id_pertanyaan)
            ->assertSessionHas('success', 'Jawaban berhasil ditambahkan!');

        // Assert that the jawaban is created in the database
        $this->assertDatabaseHas('jawaban', [
            'id_user' => $user->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'deskripsi' => $formData['deskripsi'],
        ]);
    }

    /**
     * test_create_jawaban_by_guest_user tests when guest user tries to create a jawaban
     *
     * @return void
     */
    public function test_create_jawaban_by_guest_user()
    {
        // Create pertanyaan
        $pertanyaan = User::factory()->create()->pertanyaan()->create([
            'judul' => $this->faker->text(60),
            'deskripsi' => $this->faker->text(1000),
        ]);

        // Create form data for jawaban
        $formData = [
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'deskripsi' => $this->faker->text(1000),
        ];

        // Create a jawaban
        $response = $this->post('/jawaban', $formData);

        // Assert that the user is redirected to the login page
        $response->assertStatus(302)
            ->assertRedirect('/login');

        // Assert that the jawaban is not created in the database
        $this->assertDatabaseMissing('jawaban', [
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'deskripsi' => $formData['deskripsi'],
        ]);
    }

    /**
     * test_update_jawaban_by_auth_user tests when authenticated user edits a jawaban
     *
     * @return void
     */
    public function test_update_jawaban_by_auth_user()
    {
        // Create authenticated user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create pertanyaan
        $pertanyaan = $user->pertanyaan()->create([
            'id_user' => $user->id_user,
            'judul' => $this->faker->text(60),
            'deskripsi' => $this->faker->text(1000),
        ]);

        // Create jawaban
        $jawaban = $pertanyaan->jawaban()->create([
            'id_user' => $user->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'deskripsi' => $this->faker->text(1000),
        ]);

        // Create form data for jawaban
        $formData = [
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'deskripsi' => $this->faker->text(1000),
        ];

        // Update the jawaban
        $response = $this->patch('/jawaban/' . $jawaban->id_jawaban, $formData);

        // Assert that the user is redirected to the pertanyaan page
        $response->assertStatus(302)
            ->assertRedirect('/pertanyaan/' . $pertanyaan->id_pertanyaan)
            ->assertSessionHas('success', 'Jawaban berhasil diperbarui!');

        // Assert that the jawaban is updated in the database
        $this->assertDatabaseHas('jawaban', [
            'id_user' => $user->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'deskripsi' => $formData['deskripsi'],
        ]);
    }

    /**
     * test_update_jawaban_by_other_auth_user tests when authenticated user tries to edit other user's jawaban
     *
     * @return void
     */
    public function test_update_jawaban_by_other_auth_user()
    {
        // Create authenticated users
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $this->actingAs($user1);

        // Create pertanyaan
        $pertanyaan = $user2->pertanyaan()->create([
            'id_user' => $user2->id_user,
            'judul' => $this->faker->text(60),
            'deskripsi' => $this->faker->text(1000),
        ]);

        // Create jawaban
        $jawaban = $pertanyaan->jawaban()->create([
            'id_user' => $user2->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'deskripsi' => $this->faker->text(1000),
        ]);

        // Create form data for jawaban
        $formData = [
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'deskripsi' => $this->faker->text(1000),
        ];

        // Update the jawaban
        $response = $this->patch('/jawaban/' . $jawaban->id_jawaban, $formData);

        // Assert that the user is redirected to the pertanyaan page
        $response->assertStatus(403);

        // Assert that the jawaban is not updated in the database
        $this->assertDatabaseMissing('jawaban', [
            'id_user' => $user1->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'deskripsi' => $formData['deskripsi'],
        ]);
    }

    /**
     * test_update_jawaban_by_guest_user tests when guest user tries to edit a jawaban
     *
     * @return void
     */
    public function test_update_jawaban_by_guest_user()
    {
        // Create pertanyaan
        $pertanyaan = User::factory()->create()->pertanyaan()->create([
            'judul' => $this->faker->text(60),
            'deskripsi' => $this->faker->text(1000),
        ]);

        // Create jawaban
        $jawaban = $pertanyaan->jawaban()->create([
            'id_user' => $pertanyaan->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'deskripsi' => $this->faker->text(1000),
        ]);

        // Create form data for jawaban
        $formData = [
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'deskripsi' => $this->faker->text(1000),
        ];

        // Update the jawaban
        $response = $this->patch('/jawaban/' . $jawaban->id_jawaban, $formData);

        // Assert that the user is redirected to the login page
        $response->assertStatus(302)
            ->assertRedirect('/login');

        // Assert that the jawaban is not updated in the database
        $this->assertDatabaseMissing('jawaban', [
            'id_user' => $pertanyaan->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'deskripsi' => $formData['deskripsi'],
        ]);
    }

    /**
     * test_delete_jawaban_by_auth_user tests when authenticated user deletes a jawaban
     *
     * @return void
     */
    public function test_delete_jawaban_by_auth_user()
    {
        // Create authenticated user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create pertanyaan
        $pertanyaan = $user->pertanyaan()->create([
            'id_user' => $user->id_user,
            'judul' => $this->faker->text(60),
            'deskripsi' => $this->faker->text(1000),
        ]);

        // Create jawaban
        $jawaban = $pertanyaan->jawaban()->create([
            'id_user' => $user->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'deskripsi' => $this->faker->text(1000),
        ]);

        // Delete the jawaban
        $response = $this->delete('/jawaban/' . $jawaban->id_jawaban);

        // Assert that the user is redirected to the pertanyaan page
        $response->assertStatus(302)
            ->assertRedirect('/pertanyaan/' . $pertanyaan->id_pertanyaan)
            ->assertSessionHas('success', 'Jawaban berhasil dihapus!');

        // Assert that the jawaban is deleted from the database
        $this->assertDatabaseMissing('jawaban', [
            'id_user' => $user->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'deskripsi' => $jawaban->deskripsi,
        ]);
    }

    /**
     * test_delete_jawaban_by_other_auth_user tests when authenticated user tries to delete other user's jawaban
     *
     * @return void
     */
    public function test_delete_jawaban_by_other_auth_user()
    {
        // Create authenticated users
        $user1 = User::factory()->create([
            'is_admin' => false,
        ]);
        $this->actingAs($user1);

        $user2 = User::factory()->create([
            'is_admin' => false,
        ]);

        // Create pertanyaan
        $pertanyaan = $user2->pertanyaan()->create([
            'id_user' => $user2->id_user,
            'judul' => $this->faker->text(60),
            'deskripsi' => $this->faker->text(1000),
        ]);

        // Create jawaban
        $jawaban = $pertanyaan->jawaban()->create([
            'id_user' => $user2->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'deskripsi' => $this->faker->text(1000),
        ]);

        // Delete the jawaban
        $response = $this->delete('/jawaban/' . $jawaban->id_jawaban);

        // Assert that the user is redirected to the pertanyaan page
        $response->assertStatus(403);

        // Assert that the jawaban is not deleted from the database
        $this->assertDatabaseHas('jawaban', [
            'id_user' => $user2->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'deskripsi' => $jawaban->deskripsi,
        ]);
    }

    /**
     * test_delete_jawaban_by_guest_user tests when guest user tries to delete a jawaban
     *
     * @return void
     */
    public function test_delete_jawaban_by_guest_user()
    {
        // Create pertanyaan
        $pertanyaan = User::factory()->create()->pertanyaan()->create([
            'judul' => $this->faker->text(60),
            'deskripsi' => $this->faker->text(1000),
        ]);

        // Create jawaban
        $jawaban = $pertanyaan->jawaban()->create([
            'id_user' => $pertanyaan->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'deskripsi' => $this->faker->text(1000),
        ]);

        // Delete the jawaban
        $response = $this->delete('/jawaban/' . $jawaban->id_jawaban);

        // Assert that the user is redirected to the login page
        $response->assertStatus(302)
            ->assertRedirect('/login');

        // Assert that the jawaban is not deleted from the database
        $this->assertDatabaseHas('jawaban', [
            'id_user' => $pertanyaan->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'deskripsi' => $jawaban->deskripsi,
        ]);
    }

    /**
     * test_delete_jawaban_by_admin tests when admin deletes a jawaban
     *
     * @return void
     */
    public function test_delete_jawaban_by_admin()
    {
        // Create admin
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);
        $this->actingAs($admin);

        // Create pertanyaan
        $pertanyaan = User::factory()->create()->pertanyaan()->create([
            'id_user' => $admin->id_user,
            'judul' => $this->faker->text(60),
            'deskripsi' => $this->faker->text(1000),
        ]);

        // Create jawaban
        $jawaban = $pertanyaan->jawaban()->create([
            'id_user' => $admin->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'deskripsi' => $this->faker->text(1000),
        ]);

        // Delete the jawaban
        $response = $this->delete('/jawaban/' . $jawaban->id_jawaban);

        // Assert that the user is redirected to the pertanyaan page
        $response->assertStatus(302)
            ->assertRedirect('/pertanyaan/' . $pertanyaan->id_pertanyaan)
            ->assertSessionHas('success', 'Jawaban berhasil dihapus!');

        // Assert that the jawaban is deleted from the database
        $this->assertDatabaseMissing('jawaban', [
            'id_user' => $admin->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'deskripsi' => $jawaban->deskripsi,
        ]);
    }
}
