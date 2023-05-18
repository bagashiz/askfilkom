<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Topik;
use App\Models\Pertanyaan;
use App\Models\Jawaban;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SchemaTest extends TestCase
{
    /**
     * Test the existing tables in the database.
     *
     * @return void
     */
    public function test_database_tables_exist(): void
    {
        $this->assertTrue(
            Schema::hasTable('user'),
            'Table user does not exist.'
        );
        $this->assertTrue(
            Schema::hasTable('topik'),
            'Table topik does not exist.'
        );
        $this->assertTrue(
            Schema::hasTable('pertanyaan_topik'),
            'Table pertanyaan_topik does not exist.'
        );
        $this->assertTrue(
            Schema::hasTable('pertanyaan'),
            'Table pertanyaan does not exist.'
        );
        $this->assertTrue(
            Schema::hasTable('jawaban'),
            'Table jawaban does not exist.'
        );
        $this->assertTrue(
            Schema::hasTable('vote'),
            'Table vote does not exist.'
        );
    }

    /**
     * Test the User table relations.
     *
     * @return void
     */
    public function test_user_table_relations(): void
    {
        $user = new User();
        $this->assertInstanceOf(
            HasMany::class,
            $user->pertanyaan()
        );
        $this->assertInstanceOf(
            HasMany::class,
            $user->jawaban()
        );
        $this->assertInstanceOf(
            HasMany::class,
            $user->vote()
        );
    }

    /**
     * Test the Topik table relations.
     *
     * @return void
     */
    public function test_topik_table_relations(): void
    {
        $topik = new Topik();
        $this->assertInstanceOf(
            BelongsToMany::class,
            $topik->pertanyaan()
        );
    }

    /**
     * Test the Pertanyaan table relations.
     *
     * @return void
     */
    public function test_pertanyaan_table_relations(): void
    {
        $pertanyaan = new Pertanyaan();
        $this->assertInstanceOf(
            BelongsTo::class,
            $pertanyaan->user()
        );
        $this->assertInstanceOf(
            BelongsToMany::class,
            $pertanyaan->topik()
        );
        $this->assertInstanceOf(
            HasMany::class,
            $pertanyaan->jawaban()
        );
        $this->assertInstanceOf(
            HasMany::class,
            $pertanyaan->vote()
        );
    }

    /**
     * Test the Jawaban table relations.
     *
     * @return void
     */
    public function test_jawaban_table_relations(): void
    {
        $jawaban = new Jawaban();
        $this->assertInstanceOf(
            BelongsTo::class,
            $jawaban->user()
        );
        $this->assertInstanceOf(
            BelongsTo::class,
            $jawaban->pertanyaan()
        );
        $this->assertInstanceOf(
            HasMany::class,
            $jawaban->vote()
        );
    }

    /**
     * Test the Vote table relations.
     *
     * @return void
     */
    public function test_vote_table_relations(): void
    {
        $vote = new Vote();
        $this->assertInstanceOf(
            BelongsTo::class,
            $vote->user()
        );
        $this->assertInstanceOf(
            BelongsTo::class,
            $vote->pertanyaan()
        );
        $this->assertInstanceOf(
            BelongsTo::class,
            $vote->jawaban()
        );
    }
}
