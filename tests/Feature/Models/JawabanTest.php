<?php

namespace Tests\Feature\Models;

use App\Models\User;
use App\Models\Pertanyaan;
use App\Models\Jawaban;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JawabanTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Jawaban belongs to Pertanyaan.
     *
     * @return void
     */
    public function test_jawaban_belongs_to_pertanyaan(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $pertanyaan = Pertanyaan::factory()->create(['id_user' => $user1->id_user]);

        $jawaban = Jawaban::factory()->create([
            'id_user' => $user2->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
        ]);

        $this->assertTrue($jawaban->pertanyaan->is($pertanyaan));
    }

    /**
     * Test Jawaban belongs to User.
     *
     * @return void
     */
    public function test_jawaban_belongs_to_user(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $pertanyaan = Pertanyaan::factory()->create(['id_user' => $user1->id_user]);

        $jawaban = Jawaban::factory()->create([
            'id_user' => $user2->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
        ]);

        $this->assertTrue($jawaban->user->is($user2));
    }

    /**
     * Test Jawaban has many Vote.
     *
     * @return void
     */
    public function test_jawaban_has_many_vote(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $pertanyaan = Pertanyaan::factory()->create(['id_user' => $user1->id_user]);
        $jawaban = Jawaban::factory()->create([
            'id_user' => $user2->id_user,
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
        ]);

        $jawaban->vote()->create([
            'id_user' => $user1->id_user,
            'id_jawaban' => $jawaban->id_jawaban,
        ]);
        $jawaban->vote()->create([
            'id_user' => $user2->id_user,
            'id_jawaban' => $jawaban->id_jawaban,
        ]);

        $this->assertTrue($jawaban->vote->contains('id_user', $user1->id_user));
        $this->assertTrue($jawaban->vote->contains('id_user', $user2->id_user));
    }
}
