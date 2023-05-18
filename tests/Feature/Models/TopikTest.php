<?php

namespace Tests\Feature\Models;

use App\Models\User;
use App\Models\Pertanyaan;
use App\Models\Topik;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TopikTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Topik belongs to many Pertanyaan.
     *
     * @return void
     */
    public function test_topik_belongs_to_many_pertanyaan(): void
    {
        $topik = Topik::factory()->create();
        $user = User::factory()->create();
        $pertanyaan1 = Pertanyaan::factory()->create(['id_user' => $user->id_user]);
        $pertanyaan2 = Pertanyaan::factory()->create(['id_user' => $user->id_user]);

        $topik->pertanyaan()->attach($pertanyaan1->id_pertanyaan);
        $topik->pertanyaan()->attach($pertanyaan2->id_pertanyaan);

        $this->assertTrue($topik->pertanyaan->contains($pertanyaan1));
        $this->assertTrue($topik->pertanyaan->contains($pertanyaan2));
    }
}
