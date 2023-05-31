<?php

namespace Tests\Unit\Models;

use App\Models\Pertanyaan;
use PHPUnit\Framework\TestCase;

class PertanyaanTest extends TestCase
{
    /**
     * Test the attribute types of the Pertanyaan model.
     *
     * @return void
     */
    public function test_pertanyaan_table_attributes(): void
    {
        $pertanyaan = new Pertanyaan();

        $this->assertSame('pertanyaan', $pertanyaan->getTable());
        $this->assertSame('id_pertanyaan', $pertanyaan->getKeyName());

        $this->assertSame([
            'judul',
            'deskripsi',
            'jumlah_vote',
        ], $pertanyaan->getFillable());

        $this->assertSame([
            'id_pertanyaan' => 'int',
            'jumlah_vote' => 'int',
        ], $pertanyaan->getCasts());
    }
}
