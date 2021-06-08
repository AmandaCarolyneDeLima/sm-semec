<?php

namespace Tests\Browser\Admin\Units;

use App\Models\Unit;
use App\Models\UnitCategory;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateTest extends DuskTestCase
{
    /** @var \App\Models\Unit */
    protected $unit;
    /** @var \App\Models\User */
    protected $user;
    /** @var \App\Models\UnitCategory */
    protected $categories;

    public function setUp(): void
    {
        parent::setUp();
        $this->categories = UnitCategory::factory()->count(4)->create();
        $this->unit = Unit::factory()->make([
            'name' => 'Escola Municipal Santa Cruz',
        ]);
        $this->user = User::factory()->create();
    }

    public function testSucessfullyCreate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.new.unit'));

            $category = $this->categories->first();

            $browser->type('name', $this->unit->name)
                    ->type('address', $this->unit->address)
                    ->type('phone', $this->unit->phone)
                    ->waitFor('#unit_category_id-selectized')
                    ->click('div.unit_category_id #unit_category_id-selectized')
                    ->click("div.unit_category_id .selectize-dropdown .option[data-value='{$category->id}']")
                    ->press('Criar Unidade');

            $browser->assertUrlIs(route('admin.units'));
            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Unidade cadastrada com sucesso');
            });
            $browser->with('table.table', function ($table) {
                $table->assertSee($this->unit->name);
            });
        });
    }

    public function testFailureCreate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.new.unit'));

            $browser->press('Criar Unidade');

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Existem dados incorretos! Por favor verifique!');
            });

            $browser->with('div.unit_category_id', function ($flash) {
                $flash->assertSee('O campo categoria é obrigatório.');
            });
            $browser->with('div.unit_name', function ($flash) {
                $flash->assertSee('O campo nome é obrigatório.');
            });
            $browser->with('div.unit_address', function ($flash) {
                $flash->assertSee('O campo endereço é obrigatório.');
            });
            $browser->with('div.unit_phone', function ($flash) {
                $flash->assertSee('O campo telefone é obrigatório.');
            });
        });
    }

    public function testFailureValidateCaracteresPhone(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.new.unit'));
            $category = $this->categories->first();

            $browser->type('name', $this->unit->name)
                    ->type('address', $this->unit->address)
                    ->type('phone', '12')
                    ->waitFor('#unit_category_id-selectized')
                    ->click('div.unit_category_id #unit_category_id-selectized')
                    ->click("div.unit_category_id .selectize-dropdown .option[data-value='{$category->id}']")
                    ->press('Criar Unidade');

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Existem dados incorretos! Por favor verifique!');
            });


            $browser->with('div.unit_phone', function ($flash) {
                $flash->assertSee('O campo telefone deve ter pelo menos 10 caracteres.');
            });
        });
    }

    public function testUniquenessOnCreate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.new.unit'));
            $newData = Unit::factory()->create();
            $category = $this->categories->first();

            $browser->type('name', $newData->name)
                    ->type('address', $this->unit->address)
                    ->type('phone', $newData->phone)
                    ->waitFor('#unit_category_id-selectized')
                    ->click('div.unit_category_id #unit_category_id-selectized')
                    ->click("div.unit_category_id .selectize-dropdown .option[data-value='{$category->id}']")
                    ->press('Criar Unidade');

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Existem dados incorretos! Por favor verifique!');
            });


            $browser->with('div.unit_name', function ($flash) {
                $flash->assertSee('O campo nome já está sendo utilizado.');
            });

            $browser->with('div.unit_phone', function ($flash) {
                $flash->assertSee('O campo telefone já está sendo utilizado.');
            });
        });
    }

    public function testAssertLinksPresent(): void
    {
        $this->unit = Unit::factory()->create();

        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.new.unit'));

            $backLinkSelector = "#main-card a[href='" . route('admin.units') . "']";
            $browser->assertSeeIn($backLinkSelector, 'Voltar');

            $rootBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.dashboard') . "']";
            $secondBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.units') . "']";
            $thirdBreadcrumbSelector = ".breadcrumb li:nth-child(3)";
            $browser->assertSeeIn($rootBreadcrumbSelector, 'Página Inicial');
            $browser->assertSeeIn($secondBreadcrumbSelector, 'Unidades');
            $browser->assertSeeIn($thirdBreadcrumbSelector, "Nova Unidade");
        });
    }
}
