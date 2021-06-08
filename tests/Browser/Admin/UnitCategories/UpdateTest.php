<?php

namespace Tests\Browser\Admin\UnitCategories;

use App\Models\UnitCategory;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UpdateTest extends DuskTestCase
{
    /** @var \App\Models\UnitCategory*/
    protected $category;
    /** @var \App\Models\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->category = UnitCategory::factory()->create();
        $this->user = User::factory()->create();
    }

    public function testFilledFields(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.edit.unit_category', $this->category->id));

            $browser->assertInputValue('name', $this->category->name);
        });
    }

    public function testSucessfullyUpdate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.edit.unit_category', $this->category->id));

            $newData = UnitCategory::factory()->make([
                'name' => 'Cmei',
            ]);

            $browser->type('name', $newData->name)
                    ->press('Atualizar Categoria');

            $browser->assertUrlIs(route('admin.unit_categories'));
            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Categoria atualizada com sucesso');
            });
            $browser->with('table.table', function ($table) use ($newData) {
                $table->assertSee($newData->name);
                $table->assertDontSee($this->category->name);
            });
        });
    }

    public function testFailuteUpdate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.edit.unit_category', $this->category->id));

            $browser->type('name', '')
                    ->press('Atualizar Categoria');

            $browser->assertUrlIs(route('admin.update.unit_category', $this->category->id));
            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Existem dados incorretos! Por favor verifique!');
            });

            $browser->with('div.unit_category_name', function ($flash) {
                $flash->assertSee('O campo nome é obrigatório.');
            });
        });
    }

    public function testUniquenessOnUpdate(): void
    {
        $this->browse(function ($browser) {
            $category = UnitCategory::factory()->create();
            $browser->loginAs($this->user)->visit(route('admin.edit.unit_category', $this->category->id));


            $browser->type('name', $category->name)
                    ->press('Atualizar Categoria');

            $browser->with('div.unit_category_name', function ($flash) {
                $flash->assertSee('O campo nome já está sendo utilizado.');
            });

            $browser->type('name', $this->category->name)
                    ->press('Atualizar Categoria');

            $browser->assertUrlIs(route('admin.unit_categories'));
            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Categoria atualizada com sucesso');
            });
            $browser->with('table.table', function ($table) {
                $table->assertSee($this->category->name);
            });
        });
    }


    public function testAssertLinksPresent(): void
    {
        $this->category = UnitCategory::factory()->create();

        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.edit.unit_category', $this->category->id));

            $backLinkSelector = "#main-card a[href='" . route('admin.unit_categories') . "']";
            $browser->assertSeeIn($backLinkSelector, 'Voltar');

            $rootBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.dashboard') . "']";
            $secondBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.unit_categories') . "']";
            $thirdBreadcrumbSelector = ".breadcrumb li:nth-child(3)";
            $browser->assertSeeIn($rootBreadcrumbSelector, 'Página Inicial');
            $browser->assertSeeIn($secondBreadcrumbSelector, 'Categorias');
            $browser->assertSeeIn($thirdBreadcrumbSelector, "Editar Categoria #{$this->category->id}");
        });
    }
}
