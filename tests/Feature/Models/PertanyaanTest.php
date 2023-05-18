<?php

namespace Tests\Feature\Models;

use App\Models\User;
use App\Models\Pertanyaan;
use App\Models\Jawaban;
use App\Models\Vote;
use App\Models\Topik;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PertanyaanTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Pertanyaan belongs to User.
     *
     * @return void
     */
    public function test_pertanyaan_belongs_to_user(): void
    {
        $user = User::factory()->create();

        $pertanyaan = Pertanyaan::factory()->create(['id_user' => $user->id_user]);

        $this->assertTrue($pertanyaan->user->is($user));
    }

    /**
     * Test Pertanyaan belongs to many Topik.
     *
     * @return void
     */
    public function test_pertanyaan_belongs_to_many_topik(): void
    {
        $user = User::factory()->create();
        $pertanyaan = Pertanyaan::factory()->create(['id_user' => $user->id_user]);
        $topik1 = Topik::factory()->create();
        $topik2 = Topik::factory()->create();

        $pertanyaan->topik()->attach($topik1->id_topik);
        $pertanyaan->topik()->attach($topik2->id_topik);

        $this->assertTrue($pertanyaan->topik->contains($topik1));
        $this->assertTrue($pertanyaan->topik->contains($topik2));
    }

    /**
     * Test Pertanyaan has many Jawaban.
     *
     * @return void
     */
    public function test_pertanyaan_has_many_jawaban(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $pertanyaan = Pertanyaan::factory()->create(['id_user' => $user1->id_user]);

        $jawaban1 = Jawaban::factory()->create([
            'id_user' => $user1->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
        ]);
        $jawaban2 = Jawaban::factory()->create([
            'id_user' => $user2->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
        ]);

        $this->assertTrue($pertanyaan->jawaban->contains($jawaban1));
        $this->assertTrue($pertanyaan->jawaban->contains($jawaban2));
    }

    /**
     * Test Pertanyaan has many Vote.
     *
     * @return void
     */
    public function test_pertanyaan_has_many_vote(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $pertanyaan = Pertanyaan::factory()->create(['id_user' => $user1->id_user]);

        $vote1 = Vote::factory()->create([
            'id_user' => $user1->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
        ]);

        $vote2 = Vote::factory()->create([
            'id_user' => $user2->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
        ]);

        $this->assertTrue($pertanyaan->vote->contains($vote1));
        $this->assertTrue($pertanyaan->vote->contains($vote2));
    }
}
