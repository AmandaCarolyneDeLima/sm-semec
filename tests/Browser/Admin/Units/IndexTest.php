<?php

namespace Tests\Browser\Admin\Units;

use App\Models\Unit;
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
        $units = Unit::factory()->count(10)->create();
        $units = $units->sortBy('name')->reverse();

        $this->browse(function ($browser) use ($units) {
            $browser->loginAs($this->user)->visit('/admin/units');

            $browser->with("table.table tbody", function ($row) use ($units) {
                $pos = 0;
                foreach ($units as $unit) {
                    $pos += 1;
                    $baseSelector = "tr:nth-child({$pos}) ";

                    $editSelector = $baseSelector . "a[href='" . route('admin.edit.unit', $unit->id) . "']";
                    $deleteSelector = $baseSelector . "form[action='" . route('admin.destroy.unit', $unit->id) . "']";
                    $row->assertPresent($editSelector);
                    $row->assertPresent($deleteSelector);
                }
            });
        });
    }

    public function testSearchField(): void
    {
        $unit = Unit::factory()->create(['name' => 'Unit name']);

        $this->browse(function ($browser) use ($unit) {
            $browser->loginAs($this->user);

            $browser->visit('/admin/units')
                    ->type('#search_input', $unit->name)
                    ->press('#search')
                    ->assertUrlIs(route('admin.search.units', $unit->name));

            $term = $unit->name;
            $browser->type('#search_input', $term);
            $browser->keys('#search_input', '{enter}')->assertUrlIs(route('admin.search.units', $term));
        });
    }

    public function testAssertLinksPresent(): void
    {
        Unit::factory()->count(22)->create();

        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit('/admin/units');

            $newLinkSelector = "#main-card a[href='" . route('admin.new.unit') . "']";
            $rootBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.dashboard') . "']";
            $secondBreadcrumSelector = ".breadcrumb li:nth-child(2)";

            $browser->assertSeeIn($newLinkSelector, 'Nova Unidade');
            $browser->assertSeeIn($rootBreadcrumbSelector, 'Página Inicial');
            $browser->assertSeeIn($secondBreadcrumSelector, 'Unidades');

            $browser->with('.pagination', function ($pagination) {
                $pagination->assertSee('1');
                $pagination->assertSeeLink('2');
            });
        });
    }
}
