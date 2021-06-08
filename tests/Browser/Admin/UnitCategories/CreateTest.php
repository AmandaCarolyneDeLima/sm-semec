<?php

namespace Tests\Browser\Admin\UnitCategories;

use App\Models\UnitCategory;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateTest extends DuskTestCase
{
    /** @var \App\Models\UnitCategory */
    protected $category;
    /** @var \App\Models\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->category = UnitCategory::factory()->make([
            'name' => 'Cmei',
        ]);
        $this->user = User::factory()->create();
    }

    public function testSucessfullyCreate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.new.unit_category'));
            $browser->type('name', $this->category->name)
                    ->press('Criar Categoria');

            $browser->assertUrlIs(route('admin.unit_categories'));
            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Categoria cadastrada com sucesso');
            });
        });
    }

    public function testFailureCreate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.new.unit_category'));

            $browser->press('Criar Categoria');

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Existem dados incorretos! Por favor verifique!');
            });

            $browser->with('div.unit_category_name', function ($flash) {
                $flash->assertSee('O campo nome é obrigatório.');
            });
        });
    }

    public function testUniquenessOnCreate(): void
    {
        $this->browse(function ($browser) {
            $category = UnitCategory::factory()->create();
            $browser->loginAs($this->user)->visit(route('admin.new.unit_category'));

            $browser->type('name', $category->name)
                    ->press('Criar Categoria');

            $browser->with('div.unit_category_name', function ($flash) {
                $flash->assertSee('O campo nome já está sendo utilizado.');
            });
        });
    }

    public function testAssertLinksPresent(): void
    {
        $this->category = UnitCategory::factory()->create();

        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.new.unit_category'));

            $backLinkSelector = "#main-card a[href='" . route('admin.unit_categories') . "']";
            $browser->assertSeeIn($backLinkSelector, 'Voltar');

            $rootBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.dashboard') . "']";
            $secondBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.unit_categories') . "']";
            $thirdBreadcrumbSelector = ".breadcrumb li:nth-child(3)";
            $browser->assertSeeIn($rootBreadcrumbSelector, 'Página Inicial');
            $browser->assertSeeIn($secondBreadcrumbSelector, 'Categorias');
            $browser->assertSeeIn($thirdBreadcrumbSelector, "Nova Categoria");
        });
    }
}
