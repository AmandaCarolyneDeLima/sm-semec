<?php

namespace Tests\Browser\Admin\Edicts;

use App\Models\Edict;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class IndexTest extends DuskTestCase
{
    /** @var \App\Models\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function testIndexList(): void
    {
        $edicts = Edict::factory()->count(3)->create();
        $edicts = $edicts->sortBy('started_at')->reverse();

        $this->browse(function ($browser) use ($edicts) {
            $browser->loginAs($this->user)->visit('/admin/edicts');

            $browser->with("table.table tbody", function ($row) use ($edicts) {
                $pos = 0;
                foreach ($edicts as $edict) {
                    $pos += 1;
                    $baseSelector = "tr:nth-child({$pos}) ";

                    $showSelector = $baseSelector . "a[href='" . route('admin.show.edict', $edict->id) . "']";
                    $row->assertSeeIn($showSelector, $edict->title);
                    $row->assertSeeIn($baseSelector, $edict->started_at->toShortDateTime());
                    $row->assertSeeIn($baseSelector, $edict->ended_at->toShortDateTime());

                    $editSelector = $baseSelector . "a[href='" . route('admin.edit.edict', $edict->id) . "']";
                    $deleteSelector = $baseSelector . "form[action='" . route('admin.destroy.edict', $edict->id) . "']";
                    $row->assertPresent($editSelector);
                    $row->assertPresent($deleteSelector);
                }
            });
        });
    }

    public function testSearchField(): void
    {
        $edict = Edict::factory()->create(['title' => 'Edict title']);

        $this->browse(function ($browser) use ($edict) {
            $browser->loginAs($this->user);

            $browser->visit('/admin/edicts')
                    ->type('#search_input', $edict->title)
                    ->press('#search')
                    ->assertUrlIs(route('admin.search.edicts', $edict->title));

            $browser->assertInputValue('term', $edict->title);
            $browser->with("table.table tbody tr:nth-child(1)", function ($row) use ($edict) {
                $showSelector = "a[href='" . route('admin.show.edict', $edict->id) . "']";
                $row->assertSeeIn($showSelector, $edict->title);
            });

            $term = time();
            $browser->type('#search_input', $term);
            $browser->keys('#search_input', '{enter}')->assertUrlIs(route('admin.search.edicts', $term));

            $browser->assertDontSee($edict->title);
        });
    }


    public function testAssertLinksPresent(): void
    {
        Edict::factory()->count(22)->create();

        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit('/admin/edicts');

            $newLinkSelector = "#main-card a[href='" . route('admin.new.edict') . "']";
            $rootBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.dashboard') . "']";
            $secondBreadcrumSelector = ".breadcrumb li:nth-child(2)";

            $browser->assertSeeIn($newLinkSelector, 'Novo Edital');
            $browser->assertSeeIn($rootBreadcrumbSelector, 'Página Inicial');
            $browser->assertSeeIn($secondBreadcrumSelector, 'Editais');

            $browser->with('.pagination', function ($pagination) {
                $pagination->assertSee('1');
                $pagination->assertSeeLink('2');
            });
        });
    }
}
