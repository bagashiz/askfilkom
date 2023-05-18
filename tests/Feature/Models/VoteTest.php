<?php

namespace Tests\Feature\Models;

use App\Models\User;
use App\Models\Pertanyaan;
use App\Models\Jawaban;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VoteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Vote belongs to User.
     *
     * @return void
     */
    public function test_vote_belongs_to_user(): void
    {
        $user = User::factory()->create();

        $vote = Vote::factory()->create(['id_user' => $user->id_user]);

        $this->assertTrue($vote->user->is($user));
    }

    /**
     * Test Vote belongs to Pertanyaan.
     *
     * @return void
     */
    public function test_vote_belongs_to_pertanyaan(): void
    {
        $user = User::factory()->create();
        $pertanyaan = Pertanyaan::factory()->create(['id_user' => $user->id_user]);

        $vote = Vote::factory()->create([
            'id_user' => $user->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan
        ]);

        $this->assertTrue($vote->pertanyaan->is($pertanyaan));
    }

    /**
     * Test Vote belongs to Jawaban.
     *
     * @return void
     */
    public function test_vote_belongs_to_jawaban(): void
    {
        $user = User::factory()->create();
        $pertanyaan = Pertanyaan::factory()->create(['id_user' => $user->id_user]);
        $jawaban = Jawaban::factory()->create([
            'id_user' => $user->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan
        ]);

        $vote = Vote::factory()->create([
            'id_user' => $user->id_user,
            'id_jawaban' => $jawaban->id_jawaban
        ]);

        $this->assertTrue($vote->jawaban->is($jawaban));
    }
}
