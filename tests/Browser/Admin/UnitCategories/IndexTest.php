<?php

namespace Tests\Browser\Admin\UnitCategories;

use App\Models\UnitCategory;
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
        $categories = UnitCategory::factory()->count(3)->create();
        $categories = $categories->sortBy('name')->reverse();

        $this->browse(function ($browser) use ($categories) {
            $browser->loginAs($this->user)->visit('/admin/unit-categories');

            $browser->with("table.table tbody", function ($row) use ($categories) {
                $pos = 0;
                foreach ($categories as $category) {
                    $pos += 1;
                    $baseSelector = "tr:nth-child({$pos}) ";

                    $editSelector = $baseSelector . "a[href='" .
                     route('admin.edit.unit_category', $category->id) . "']";
                    $deleteSelector = $baseSelector . "form[action='" .
                    route('admin.destroy.unit_category', $category->id) . "']";
                    $row->assertPresent($editSelector);
                    $row->assertPresent($deleteSelector);
                }
            });
        });
    }

    public function testSearchField(): void
    {
        $category = UnitCategory::factory()->create(['name' => 'Unit category name']);

        $this->browse(function ($browser) use ($category) {
            $browser->loginAs($this->user);

            $browser->visit('/admin/unit-categories')
                    ->type('#search_input', $category->name)
                    ->press('#search')
                    ->assertUrlIs(route('admin.search.unit_categories', $category->name));

            $term = time();
            $browser->type('#search_input', $term);
            $browser->keys('#search_input', '{enter}')->assertUrlIs(route('admin.search.unit_categories', $term));

            $browser->assertDontSee($category->name);
        });
    }

    public function testAssertLinksPresent(): void
    {
        UnitCategory::factory()->count(22)->create();

        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit('/admin/unit-categories');

            $newLinkSelector = "#main-card a[href='" . route('admin.new.unit_category') . "']";
            $rootBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.dashboard') . "']";
            $secondBreadcrumSelector = ".breadcrumb li:nth-child(2)";

            $browser->assertSeeIn($newLinkSelector, 'Nova Categoria');
            $browser->assertSeeIn($rootBreadcrumbSelector, 'Página Inicial');
            $browser->assertSeeIn($secondBreadcrumSelector, 'Categorias');

            $browser->with('.pagination', function ($pagination) {
                $pagination->assertSee('1');
                $pagination->assertSeeLink('2');
            });
        });
    }
}
