<?php

namespace Tests\Unit\Models;

use App\Models\Vote;
use PHPUnit\Framework\TestCase;

class VoteTest extends TestCase
{
    /**
     * Test the attribute types of the Vote model.
     *
     * @return void
     */
    public function test_vote_table_attributes(): void
    {
        $vote = new Vote();

        $this->assertSame([
            'id_user',
            'id_pertanyaan',
            'id_jawaban',
        ], $vote->getFillable());

        $this->assertSame('id_vote', $vote->getKeyName());
        $this->assertSame('vote', $vote->getTable());
    }
}
