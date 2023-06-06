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

        // Get 2 random topik id
        $id_topik_arr = $topik->random(2)->pluck('id_topik')->all();

        // Create form data for pertanyaan
        $formData = [
            'judul' => $this->faker->text(60),
            'deskripsi' => $this->faker->text(1000),
            'topik' => $id_topik_arr,
        ];

        // Create a pertanyaan
        $response = $this->post('/pertanyaan', $formData);

        // Assert that the user is redirected to the home page and sees the success message
        $response->assertStatus(302)
            ->assertRedirect('/')
            ->assertSessionHas('success', 'Pertanyaan berhasil dibuat!');

        // Assert that the pertanyaan was created
        $this->assertDatabaseHas('pertanyaan', [
            'id_user' => $user->id_user,
            'judul' =>  $formData['judul'],
            'deskripsi' => $formData['deskripsi'],
        ]);
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

        // Get 2 random topik id
        $id_topik_arr = $topik->random(2)->pluck('id_topik')->all();

        // Create form data for pertanyaan
        $formData = [
            'judul' => $this->faker->text(60),
            'deskripsi' => $this->faker->text(1000),
            'topik' => $id_topik_arr,
        ];

        // Create a pertanyaan
        $response = $this->post('/pertanyaan', $formData);

        // Assert that the user is redirected to the login page
        $response->assertStatus(302)
            ->assertRedirect('/login');


        // Assert that the pertanyaan was not created
        $this->assertDatabaseMissing('pertanyaan', [
            'judul' =>  $formData['judul'],
            'deskripsi' => $formData['deskripsi'],
        ]);
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

        // Get 2 random topik id
        $id_topik_arr = $topik->random(2)->pluck('id_topik')->all();
        $id_topik_arr2 = $topik->random(2)->pluck('id_topik')->all();

        // Create a pertanyaan to be updated
        $pertanyaan = $user->pertanyaan()->create([
            'judul' => $this->faker->text(60),
            'deskripsi' => $this->faker->text(1000),
            'topik' => $id_topik_arr,
        ]);

        // Update the pertanyaan
        $response = $this->patch('/pertanyaan/' . $pertanyaan->id_pertanyaan, [
            'judul' => 'Updated Judul',
            'deskripsi' => 'Updated Deskripsi',
            'topik' => $id_topik_arr2,
        ]);

        // Assert that the user is redirected to the home page and sees the success message
        $response->assertStatus(302)
            ->assertRedirect('/pertanyaan/' . $pertanyaan->id_pertanyaan)
            ->assertSessionHas('success', 'Pertanyaan berhasil diperbarui!');

        // Assert that the pertanyaan was updated
        $this->assertDatabaseHas('pertanyaan', [
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'id_user' => $user->id_user,
            'judul' => 'Updated Judul',
            'deskripsi' => 'Updated Deskripsi',
        ]);
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

        // Get 2 random topik id
        $id_topik_arr = $topik->random(2)->pluck('id_topik')->all();
        $id_topik_arr2 = $topik->random(2)->pluck('id_topik')->all();

        // Create a pertanyaan by the other user to be updated
        $pertanyaan = $user2->pertanyaan()->create([
            'judul' => $this->faker->text(60),
            'deskripsi' => $this->faker->text(1000),
            'topik' => $id_topik_arr,
        ]);

        // Update the pertanyaan by authenticated user
        $response = $this->patch('/pertanyaan/' . $pertanyaan->id_pertanyaan, [
            'judul' => 'Updated Judul',
            'deskripsi' => 'Updated Deskripsi',
            'topik' => $id_topik_arr2,
        ]);

        // Assert abort 403
        $response->assertStatus(403);

        // Assert that the updated pertanyaan is not found in the database
        $this->assertDatabaseMissing('pertanyaan', [
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'id_user' => $user1->id_user,
            'judul' => 'Updated Judul',
            'deskripsi' => 'Updated Deskripsi',
        ]);
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

        // Get 2 random topik id
        $id_topik_arr = $topik->random(2)->pluck('id_topik')->all();
        $id_topik_arr2 = $topik->random(2)->pluck('id_topik')->all();

        // Create a pertanyaan to be updated
        $pertanyaan = $user->pertanyaan()->create([
            'judul' => $this->faker->text(60),
            'deskripsi' => $this->faker->text(1000),
            'topik' => $id_topik_arr,
        ]);

        // Update the pertanyaan
        $response = $this->patch('/pertanyaan/' . $pertanyaan->id_pertanyaan, [
            'judul' => 'Updated Judul',
            'deskripsi' => 'Updated Deskripsi',
            'topik' => $id_topik_arr2,
        ]);

        // Assert that the user is redirected to the login page
        $response->assertStatus(302)
            ->assertRedirect('/login');

        // Assert that the pertanyaan was not updated
        $this->assertDatabaseMissing('pertanyaan', [
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'judul' => 'Updated Judul',
            'deskripsi' => 'Updated Deskripsi',
        ]);
    }

    /**
     * test_delete_pertanyaan_by_auth_user tests when authenticated user tries to delete a pertanyaan
     *
     * @return void
     */
    public function test_delete_pertanyaan_by_auth_user(): void
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a list of topik
        $topik = Topik::factory()->count(10)->create();

        // get 2 random topik id
        $id_topik_arr = $topik->random(2)->pluck('id_topik')->all();

        // Create a pertanyaan to be deleted
        $pertanyaan = $user->pertanyaan()->create([
            'judul' => $this->faker->text(60),
            'deskripsi' => $this->faker->text(1000),
            'topik' => $id_topik_arr,
        ]);

        // Delete the pertanyaan
        $response = $this->delete('/pertanyaan/' . $pertanyaan->id_pertanyaan);

        // Assert that the user is redirected to the home page and sees the success message
        $response->assertStatus(302)
            ->assertRedirect('/')
            ->assertSessionHas('success', 'Pertanyaan berhasil dihapus!');

        // Assert that the pertanyaan was deleted
        $this->assertDatabaseMissing('pertanyaan', [
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'judul' => $pertanyaan->judul,
            'deskripsi' => $pertanyaan->deskripsi,
        ]);
    }

    /**
     * test_delete_pertanyaan_by_other_auth_user tests when authenticated user tries to delete a pertanyaan created by other authenticated user
     *
     * @return void
     */
    public function test_delete_pertanyaan_by_other_auth_user(): void
    {
        // Create a non-admin user and authenticate
        $user1 = User::factory()->create([
            'is_admin' => false,
        ]);
        $this->actingAs($user1);

        // Create a second user
        $user2 = User::factory()->create();

        // Create a list of topik
        $topik = Topik::factory()->count(10)->create();

        // get 2 random topik id
        $id_topik_arr = $topik->random(2)->pluck('id_topik')->all();

        // Create a pertanyaan by the second user
        $pertanyaan = $user2->pertanyaan()->create([
            'judul' => $this->faker->text(60),
            'deskripsi' => $this->faker->text(1000),
            'topik' => $id_topik_arr,
        ]);

        // store the pertanyaan to database
        $pertanyaan->save();

        // Delete the pertanyaan
        $response = $this->delete('/pertanyaan/' . $pertanyaan->id_pertanyaan);

        // Assert abort 403
        $response->assertStatus(403);

        // Assert that the pertanyaan was not deleted
        $this->assertDatabaseHas('pertanyaan', [
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'judul' => $pertanyaan->judul,
            'deskripsi' => $pertanyaan->deskripsi,
        ]);
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

        // get 2 random topik id
        $id_topik_arr = $topik->random(2)->pluck('id_topik')->all();

        // Create a pertanyaan to be deleted
        $pertanyaan = $user->pertanyaan()->create([
            'judul' => $this->faker->text(60),
            'deskripsi' => $this->faker->text(1000),
            'topik' => $id_topik_arr,
        ]);

        // Delete the pertanyaan
        $response = $this->delete('/pertanyaan/' . $pertanyaan->id_pertanyaan);

        // Assert redirect to login page
        $response->assertStatus(302)
            ->assertRedirect('/login');

        // Assert that the pertanyaan was not deleted
        $this->assertDatabaseHas('pertanyaan', [
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'judul' => $pertanyaan->judul,
            'deskripsi' => $pertanyaan->deskripsi,
        ]);
    }

    /**
     * test_delete_pertanyaan_by_admin tests when admin tries to delete a pertanyaan
     *
     * @return void
     */
    public function test_delete_pertanyaan_by_admin(): void
    {
        // Create an admin user and authenticate
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);
        $this->actingAs($admin);

        // Create a user
        $user = User::factory()->create();

        // Create a list of topik
        $topik = Topik::factory()->count(10)->create();

        // get 2 random topik id
        $id_topik_arr = $topik->random(2)->pluck('id_topik')->all();

        // Create a pertanyaan to be deleted
        $pertanyaan = $user->pertanyaan()->create([
            'judul' => $this->faker->text(60),
            'deskripsi' => $this->faker->text(1000),
            'topik' => $id_topik_arr,
        ]);

        // Delete the pertanyaan
        $response = $this->delete('/pertanyaan/' . $pertanyaan->id_pertanyaan);

        // Assert that the user is redirected to the home page and sees the success message
        $response->assertStatus(302)
            ->assertRedirect('/')
            ->assertSessionHas('success', 'Pertanyaan berhasil dihapus!');

        // Assert that the pertanyaan was deleted
        $this->assertDatabaseMissing('pertanyaan', [
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'judul' => $pertanyaan->judul,
            'deskripsi' => $pertanyaan->deskripsi,
        ]);
    }
}
