<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Topik;
use App\Models\Pertanyaan;
use App\Models\Jawaban;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // Seed users
        User::factory()->count(10)->create()->each(function ($user) {
            // Seed pertanyaan for each user
            $pertanyaans = Pertanyaan::factory()->count(2)->create([
                'id_user' => $user->id_user,
            ]);

            $pertanyaans->each(function ($pertanyaan) use ($user) {
                // Seed random number of topik for each pertanyaan (1-3 topiks)
                $topiks = Topik::factory()->count(rand(1, 3))->create();

                $topiks->each(function ($topik) use ($pertanyaan) {
                    $pertanyaan->topik()->attach($topik->id_topik);
                });

                // Seed random number of jawaban for each pertanyaan (1-2 jawabans)
                Jawaban::factory()->count(rand(1, 2))->create([
                    'id_user' => User::where('id_user', '!=', $user->id_user)->inRandomOrder()->first()->id_user,
                    'id_pertanyaan' => $pertanyaan->id_pertanyaan,
                ]);

                // Seed votes for each pertanyaan
                $this->seedVotes($user, $pertanyaan);

                // Seed votes for each jawaban
                $pertanyaan->jawaban->each(function ($jawaban) use ($user) {
                    $this->seedVotes($user, $jawaban);
                });
            });
        });
    }

    /**
     * Seed votes for a given model.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     *
     * @return void
     */
    private function seedVotes(User $user, Model $model): void
    {
        if (rand(0, 1)) {
            Vote::factory()->create([
                'id_user' => $user->id_user,
                'id_pertanyaan' => $model instanceof Pertanyaan ? $model->id_pertanyaan : null,
                'id_jawaban' => $model instanceof Jawaban ? $model->id_jawaban : null,
            ]);
        }
    }
}
