<?php

namespace Tests\Unit\Models;

use App\Models\Topik;
use PHPUnit\Framework\TestCase;

class TopikTest extends TestCase
{
    /**
     * Test the attribute types of the Topik model.
     *
     * @return void
     */
    public function test_topik_table_attributes(): void
    {
        $topik = new Topik();

        $this->assertSame('id_topik', $topik->getKeyName());
        $this->assertSame('topik', $topik->getTable());

        $this->assertSame([
            'nama',
        ], $topik->getFillable());
    }
}
