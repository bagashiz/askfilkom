<?php

namespace Tests\Feature\Models;

use App\Models\User;
use App\Models\Pertanyaan;
use App\Models\Jawaban;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test User has many Pertanyaan.
     *
     * @return void
     */
    public function test_user_has_many_pertanyaan(): void
    {
        $user = User::factory()->create();

        $pertanyaan1 = Pertanyaan::factory()->create(['id_user' => $user->id_user]);
        $pertanyaan2 = Pertanyaan::factory()->create(['id_user' => $user->id_user]);

        $this->assertTrue($user->pertanyaan->contains($pertanyaan1));
        $this->assertTrue($user->pertanyaan->contains($pertanyaan2));
    }

    /**
     * Test User has many Jawaban.
     *
     * @return void
     */
    public function test_user_has_many_jawaban(): void
    {
        $user = User::factory()->create();
        $pertanyaan = Pertanyaan::factory()->create(['id_user' => $user->id_user]);

        $jawaban1 = Jawaban::factory()->create([
            'id_user' => $user->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
        ]);
        $jawaban2 = Jawaban::factory()->create([
            'id_user' => $user->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
        ]);

        $this->assertTrue($user->jawaban->contains($jawaban1));
        $this->assertTrue($user->jawaban->contains($jawaban2));
    }

    /**
     * Test User has many Vote.
     *
     * @return void
     */
    public function test_user_has_many_vote(): void
    {
        $user = User::factory()->create();
        $pertanyaan = Pertanyaan::factory()->create(['id_user' => $user->id_user]);
        $jawaban = Jawaban::factory()->create([
            'id_user' => $user->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
        ]);

        $vote1 = Vote::factory()->create([
            'id_user' => $user->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
        ]);
        $vote2 = Vote::factory()->create([
            'id_user' => $user->id_user,
            'id_jawaban' => $jawaban->id_jawaban,
        ]);

        $this->assertTrue($user->vote->contains($vote1));
        $this->assertTrue($user->vote->contains($vote2));
    }
}
