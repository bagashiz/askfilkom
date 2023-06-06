<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VoteControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * test_vote_pertanyaan_by_user tests vote pertanyaan by authenticated user
     *
     * @return void
     */
    public function test_vote_pertanyaan_by_user(): void
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a pertanyaan
        $pertanyaan = $user->pertanyaan()->create([
            'judul' => $this->faker->text(60),
            'deskripsi' => $this->faker->text(1000),
            'jumlah_vote' => 2,
        ]);

        // Send vote request
        $response = $this->post('/pertanyaan/' . $pertanyaan->id_pertanyaan . '/vote');

        // Assert it was successful
        $response->assertRedirect()
            ->assertSessionHas('success', 'Vote berhasil!');

        // Assert database has expected changes
        $this->assertDatabaseHas('vote', [
            'id_user' => $user->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'id_jawaban' => null,
        ]);

        $this->assertDatabaseHas('pertanyaan', [
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'jumlah_vote' => 3,
        ]);
    }

    /**
     * test_vote_jawaban_by_user tests vote jawaban by authenticated user
     *
     * @return void
     */
    public function test_vote_jawaban_by_user(): void
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a pertanyaan
        $pertanyaan = $user->pertanyaan()->create([
            'judul' => $this->faker->text(60),
            'deskripsi' => $this->faker->text(1000),
        ]);

        // Create a jawaban
        $jawaban = $pertanyaan->jawaban()->create([
            'id_user' => $user->id_user,
            'deskripsi' => $this->faker->text(1000),
            'jumlah_vote' => 2,
        ]);

        // Send vote request
        $response = $this->post('/jawaban/' . $jawaban->id_jawaban . '/vote');

        // Assert it was successful
        $response->assertRedirect()
            ->assertSessionHas('success', 'Vote berhasil!');

        // Assert database has expected changes
        $this->assertDatabaseHas('vote', [
            'id_user' => $user->id_user,
            'id_pertanyaan' => null,
            'id_jawaban' => $jawaban->id_jawaban,
        ]);

        $this->assertDatabaseHas('jawaban', [
            'id_jawaban' => $jawaban->id_jawaban,
            'jumlah_vote' => 3,
        ]);
    }

    /**
     * test_unvote_pertanyaan_by_user tests unvote pertanyaan by authenticated user
     *
     * @return void
     */
    public function test_unvote_pertanyaan_by_user(): void
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a pertanyaan
        $pertanyaan = $user->pertanyaan()->create([
            'judul' => $this->faker->text(60),
            'deskripsi' => $this->faker->text(1000),
            'jumlah_vote' => 2,
        ]);

        // Create a vote
        $pertanyaan->vote()->create([
            'id_user' => $user->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
        ]);

        // Send unvote request
        $response = $this->delete('/pertanyaan/' . $pertanyaan->id_pertanyaan . '/unvote');

        // Assert it was successful
        $response->assertRedirect()
            ->assertSessionHas('success', 'Unvote berhasil!');

        // Assert database has expected changes
        $this->assertDatabaseMissing('vote', [
            'id_user' => $user->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'id_jawaban' => null,
        ]);

        $this->assertDatabaseHas('pertanyaan', [
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'jumlah_vote' => 1,
        ]);
    }

    /**
     * test_unvote_jawaban_by_user tests unvote jawaban by authenticated user
     *
     * @return void
     */
    public function test_unvote_jawaban_by_user(): void
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a pertanyaan
        $pertanyaan = $user->pertanyaan()->create([
            'judul' => $this->faker->text(60),
            'deskripsi' => $this->faker->text(1000),
        ]);

        // Create a jawaban
        $jawaban = $pertanyaan->jawaban()->create([
            'id_user' => $user->id_user,
            'deskripsi' => $this->faker->text(1000),
            'jumlah_vote' => 2,
        ]);

        // Create a vote
        $jawaban->vote()->create([
            'id_user' => $user->id_user,
            'id_jawaban' => $jawaban->id_jawaban,
        ]);

        // Send unvote request
        $response = $this->delete('/jawaban/' . $jawaban->id_jawaban . '/unvote');

        // Assert it was successful
        $response->assertRedirect()
            ->assertSessionHas('success', 'Unvote berhasil!');

        // Assert database has expected changes
        $this->assertDatabaseMissing('vote', [
            'id_user' => $user->id_user,
            'id_pertanyaan' => null,
            'id_jawaban' => $jawaban->id_jawaban,
        ]);

        $this->assertDatabaseHas('jawaban', [
            'id_jawaban' => $jawaban->id_jawaban,
            'jumlah_vote' => 1,
        ]);
    }
}
