<?php

namespace Tests\Browser\Servants\Edicts;

use App\Models\Edict;
use App\Models\Servant;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class IndexTest extends DuskTestCase
{
    /** @var \App\Models\Servant */
    protected $servant;
    /** @var \App\Models\Edict */
    protected $edict;

    public function setUp(): void
    {
        parent::setUp();
        $this->servant = Servant::factory('servant')->create();
    }

    public function testIndexListOpen(): void
    {
        $edicts = Edict::factory()->count(3)->create();
        $edicts = $edicts->sortBy('started_at')->reverse();

        $this->browse(function ($browser) use ($edicts) {
            $browser->loginAs($this->servant, 'servant')->visit('/servant/edicts/open');

            $browser->with("table.table tbody", function ($row) use ($edicts) {
                $pos = 0;
                foreach ($edicts as $edict) {
                    $pos += 1;
                    $baseSelector = "tr:nth-child({$pos}) ";

                    $showSelector = $baseSelector . "a[href='" . route('servant.show.edict', $edict->id) . "']";
                    $row->assertSeeIn($showSelector, $edict->title);
                    $row->assertSeeIn($baseSelector, $edict->started_at->toShortDateTime());
                    $row->assertSeeIn($baseSelector, $edict->ended_at->toShortDateTime());
                }
            });
        });
    }

    public function testIndexListClose(): void
    {
        $edict = Edict::factory()->create(['started_at' => '16/11/2020 13:00', 'ended_at' => '17/11/2020 13:00']);
        // $edicts = $edicts->sortBy('started_at')->reverse();

        $this->browse(function ($browser) use ($edict) {
            $browser->loginAs($this->servant, 'servant')->visit('/servant/edicts/close');

            $browser->with("table.table tbody", function ($row) use ($edict) {
                $pos = 0;
                    $pos += 1;
                    $baseSelector = "tr:nth-child({$pos}) ";

                    $showSelector = $baseSelector . "a[href='" . route('servant.show.edict', $edict->id) . "']";
                    $row->assertSeeIn($showSelector, $edict->title);
                    $row->assertSeeIn($baseSelector, $edict->started_at->toShortDateTime());
                    $row->assertSeeIn($baseSelector, $edict->ended_at->toShortDateTime());
            });
        });
    }

    public function testAssertLinksPresent(): void
    {
        Edict::factory()->create();

        $this->browse(function ($browser) {
            $browser->loginAs($this->servant, 'servant')->visit('/servant/edicts/open');

            $rootBreadcrumbSelector = ".breadcrumb-item a[href='" . route('servant.dashboard') . "']";
            $secondBreadcrumSelector = ".breadcrumb li:nth-child(2)";

            $browser->assertSeeIn($rootBreadcrumbSelector, 'Página Inicial');
            $browser->assertSeeIn($secondBreadcrumSelector, 'Editais');
        });
    }

    public function testSearchField(): void
    {
        $edict = Edict::factory()->create(['title' => 'Edict title']);

        $this->browse(function ($browser) use ($edict) {
            $browser->loginAs($this->servant, 'servant');

            $browser->visit('/servant/edicts/open')
                    ->type('#search_input', $edict->title)
                    ->press('#search')
                    ->assertUrlIs(route('servant.search.edicts', $edict->title));

            $browser->assertInputValue('term', $edict->title);
            $browser->with("table.table tbody tr:nth-child(1)", function ($row) use ($edict) {
                $showSelector = "a[href='" . route('servant.show.edict', $edict->id) . "']";
                $row->assertSeeIn($showSelector, $edict->title);
            });

            $term = time();
            $browser->type('#search_input', $term);
            $browser->keys('#search_input', '{enter}')->assertUrlIs(route('servant.search.edicts', $term));

            $browser->assertDontSee($edict->title);
        });
    }
}
