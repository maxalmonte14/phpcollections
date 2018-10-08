<?php

namespace Tests\Unit;

use PHPCollections\DataHolder;
use PHPUnit\Framework\TestCase;

class DataHolderTest extends TestCase
{
    private $dataHolder;

    public function setUp()
    {
        $this->dataHolder = new DataHolder([
            'name' => 'Max',
            'age'  => '24',
        ]);
    }

    /** @test */
    public function it_can_add_elements()
    {
        $this->dataHolder->offsetSet('job', 'Programmer');
        $this->assertEquals('Programmer', $this->dataHolder->offsetGet('job'));
    }

    /** @test */
    public function it_can_remove_elements()
    {
        $this->dataHolder->offsetUnset('name');
        $this->assertArrayNotHasKey('name', $this->dataHolder);
    }
}
