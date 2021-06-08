<?php

namespace Tests\Unit\Edicts;

use App\Models\Edict;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class EdictSearchTest extends TestCase
{
    use DatabaseTransactions;

    /** @var array */
    protected $edicts;

    public function setUp(): void
    {
        parent::setUp();
        $this->edicts[] = Edict::factory()->create(['title' => 'Edital 2019/1 - Permuta',
            'started_at' => '24/11/2020 12:00', 'ended_at' => '25/11/2020 13:00']);
        $this->edicts[] = Edict::factory()->create(['title' => 'Edital 2019/2 - Remoção',
            'started_at' => '24/11/2020 12:00','ended_at' => '25/11/2020 13:00']);
        $this->edicts[] = Edict::factory()->create(['title' => 'Edital 2019/3 - Informativo',
           'started_at' => '24/11/2020 12:00','ended_at' => '25/11/2020 13:00']);
        $this->edicts[] = Edict::factory()->create(['title' => 'Edital 2019/4 - Permuta',
           'started_at' => '24/11/2020 12:00','ended_at' => '25/11/2020 13:00']);
        $this->edicts[] = Edict::factory()->create(['title' => 'Edital 2019/5 - Remoção',
           'started_at' => '24/11/2020 12:00','ended_at' => '25/11/2020 13:00']);
        $this->edicts[] = Edict::factory()->create(['title' => 'Edital 2020/1 - Permuta',
           'started_at' => '24/11/2020 12:00','ended_at' => '25/11/2020 13:00']);
        $this->edicts[] = Edict::factory()->create(['title' => 'Edital 2020/2 - Remoção',
           'started_at' => '24/11/2020 12:00','ended_at' => '25/11/2020 13:00']);
        $this->edicts[] = Edict::factory()->create(['title' => 'Edital 2020/3- Permuta',
           'started_at' => '24/11/2020 12:00','ended_at' => '25/11/2020 13:00']);
        $this->edicts[] = Edict::factory()->create(['title' => 'Edital 2020/4 - Permuta',
           'started_at' => '24/11/2020 12:00','ended_at' => '25/11/2020 13:00']);
        $this->edicts[] = Edict::factory()->create(['title' => 'Edital 2020/5 - Permuta',
            'started_at' => '24/11/2020 12:00', 'ended_at' => '25/11/2020 23:59']);
    }

    public function testSearchBySpecifiedName(): void
    {
        $searchResult = Edict::search('Edital 2019/1 - Permuta');
        $expectedEdicts = collect([$this->edicts[0]]);

        $this->assertEquals(1, $searchResult->count());
        $this->assertEmpty($searchResult->diff($expectedEdicts));
    }

    public function testSearcClosehBySpecifiedName(): void
    {
        $searchResult = Edict::searchClose('Edital 2019/1 - Permuta');
        $expectedEdicts = collect([$this->edicts[0]]);

        $this->assertEquals(1, $searchResult->count());
        $this->assertEmpty($searchResult->diff($expectedEdicts));
    }

    public function testSearchOpenBySpecifiedName(): void
    {
        $searchResult = Edict::searchOpen('Edital 2019/1 - Permuta');
        $expectedEdicts = collect([$this->edicts[0]]);

        $this->assertEquals(0, $searchResult->count());
        $this->assertEmpty($searchResult->diff($expectedEdicts));
    }

    public function testSearchContainsSyllable(): void
    {
        $searchResult = Edict::search('ção');
        $expectedEdicts = collect($this->edicts);

        $this->assertEquals(3, $searchResult->count());
        $this->assertEmpty($searchResult->diff(collect($expectedEdicts)));
    }

    public function testSearchCloseContainsSyllable(): void
    {
        $searchResult = Edict::searchClose('ção');
        $expectedEdicts = collect($this->edicts);

        $this->assertEquals(3, $searchResult->count());
        $this->assertEmpty($searchResult->diff(collect($expectedEdicts)));
    }

    public function testSearchOpenContainsSyllable(): void
    {
        $searchResult = Edict::searchOpen('ção');
        $expectedEdicts = collect($this->edicts);

        $this->assertEquals(0, $searchResult->count());
        $this->assertEmpty($searchResult->diff(collect($expectedEdicts)));
    }

    public function testSearchForYear(): void
    {
        $searchResult = Edict::search('2019');
        $expectedEdicts = collect($this->edicts);

        $this->assertEquals(5, $searchResult->count());
        $this->assertEmpty($searchResult->diff(collect($expectedEdicts)));
    }

    public function testSearchCloseForYear(): void
    {
        $searchResult = Edict::searchClose('2019');
        $expectedEdicts = collect($this->edicts);

        $this->assertEquals(5, $searchResult->count());
        $this->assertEmpty($searchResult->diff(collect($expectedEdicts)));
    }

    public function testSearchOpenForYear(): void
    {
        $searchResult = Edict::searchOpen('2019');
        $expectedEdicts = collect($this->edicts);

        $this->assertEquals(0, $searchResult->count());
        $this->assertEmpty($searchResult->diff(collect($expectedEdicts)));
    }

    public function testSearchEmpty(): void
    {
        $searchResult = Edict::search('');
        $expectedEdicts = collect($this->edicts);

        $this->assertEquals(10, $searchResult->count());
        $this->assertEmpty($searchResult->diff(collect($expectedEdicts)));
    }

    public function testSearchCloseEmpty(): void
    {
        $searchResult = Edict::searchClose('');
        $expectedEdicts = collect($this->edicts);

        $this->assertEquals(9, $searchResult->count());
        $this->assertEmpty($searchResult->diff(collect($expectedEdicts)));
    }

    public function testSearchOpenEmpty(): void
    {
        $searchResult = Edict::searchOpen('');
        $expectedEdicts = collect($this->edicts);

        $this->assertEquals(1, $searchResult->count());
        $this->assertEmpty($searchResult->diff(collect($expectedEdicts)));
    }
}
