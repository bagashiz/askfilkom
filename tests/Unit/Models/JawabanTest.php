<?php

namespace Tests\Unit\Models;

use App\Models\Jawaban;
use PHPUnit\Framework\TestCase;

class JawabanTest extends TestCase
{
    /**
     * Test the attribute types of the Jawaban model.
     *
     * @return void
     */
    public function test_jawaban_table_attributes(): void
    {
        $jawaban = new Jawaban();

        $this->assertSame('id_jawaban', $jawaban->getKeyName());
        $this->assertSame('jawaban', $jawaban->getTable());

        $this->assertSame([
            'id_user',
            'deskripsi',
        ], $jawaban->getFillable());

        $this->assertSame([
            'id_jawaban' => 'int',
            'jumlah_vote' => 'int',
        ], $jawaban->getCasts());
    }
}
