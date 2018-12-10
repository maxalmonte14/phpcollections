<?php

namespace Tests\Unit;

use PHPCollections\Store;
use PHPUnit\Framework\TestCase;

class StoreTest extends TestCase
{
    private $store;

    public function setUp()
    {
        $this->store = new Store([
            'name' => 'Max',
            'age'  => '24',
        ]);
    }

    /** @test */
    public function it_can_add_elements()
    {
        $this->store->offsetSet('job', 'Programmer');
        $this->assertEquals('Programmer', $this->store->offsetGet('job'));
    }

    /** @test */
    public function it_can_remove_elements()
    {
        $this->store->offsetUnset('name');
        $this->assertArrayNotHasKey('name', $this->store);
    }

    /** @test */
    public function it_can_get_the_first_element()
    {
        $this->assertEquals('Max', $this->store->first());
    }

    /** @test */
    public function it_can_get_the_last_element()
    {
        $this->assertEquals('24', $this->store->last());
    }

    /** @test */
    public function it_can_be_serialized_to_json()
    {
        $this->assertEquals('{"name":"Max","age":"24"}', json_encode($this->store));
    }
}
