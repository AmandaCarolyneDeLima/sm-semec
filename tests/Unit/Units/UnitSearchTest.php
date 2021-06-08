<?php

namespace Tests\Unit\Units;

use App\Models\Unit;
use App\Models\UnitCategory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UnitSearchTest extends TestCase
{
    use DatabaseTransactions;

    /** @var array */
    protected $units;

    public function setUp(): void
    {
        parent::setUp();
        $this->units[] = Unit::factory()->create(['name' => 'Escola Municipal Dalila']);
        $this->units[] = Unit::factory()->create(['name' => 'Escola Municipal Santa Cruz']);
        $this->units[] = Unit::factory()->create(['name' => 'Departamento De Informática Educativa']);
        $this->units[] = Unit::factory()->create(['name' => 'Departamento De Assuntos Culturais']);
        $this->units[] = Unit::factory()->create(['name' => 'Cmei Boqueirão']);
        $this->units[] = Unit::factory()->create(['name' => 'Cmei Vila Carli']);
    }

    public function testSearchBySpecifiedName(): void
    {
        $searchResult = Unit::search('Escola Municipal Dalila');
        $expectedUnits = collect([$this->units[0]]);

        $this->assertEquals(1, $searchResult->count());
        $this->assertEmpty($searchResult->diff($expectedUnits));
    }

    public function testSearchContainsSyllable(): void
    {
        $searchResult = Unit::search('mei');
        $expectedUnits = collect($this->units);

        $this->assertEquals(2, $searchResult->count());
        $this->assertEmpty($searchResult->diff(collect($expectedUnits)));
    }


    public function testSearchEmpty(): void
    {
        $searchResult = Unit::search('');
        $expectedUnits = collect($this->units);

        $this->assertEquals(6, $searchResult->count());
        $this->assertEmpty($searchResult->diff(collect($expectedUnits)));
    }
}
