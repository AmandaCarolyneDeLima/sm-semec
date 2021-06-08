<?php

namespace Tests\Browser\Admin\Units;

use App\Models\Unit;
use App\Models\UnitCategory;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UpdateTest extends DuskTestCase
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
        $this->unit = Unit::factory()->create();
        $this->user = User::factory()->create();
        $this->categories = UnitCategory::factory()->count(4)->create();
    }

    public function testFilledFields(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.edit.unit', $this->unit->id));

            $browser->assertInputValue('name', $this->unit->name)
                    ->assertInputValue('address', str_replace("\n", "", $this->unit->address))
                    ->assertInputValue('phone', $this->unit->phone)
                    ->assertSelected('category_id', $this->unit->category_id);
        });
    }

    public function testSucessfullyUpdate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.edit.unit', $this->unit->id));

            $unitData = Unit::factory()->make([
                'name' => 'Escola Municipal Stange',
            ]);
            $category = $this->categories->first();

            $browser->type('name', $unitData->name)
                    ->type('address', $unitData->address)
                    ->type('phone', $unitData->phone)
                    ->waitFor('#unit_category_id-selectized')
                    ->click('div.unit_category_id #unit_category_id-selectized')
                    ->click("div.unit_category_id .selectize-dropdown .option[data-value='{$category->id}']")
                    ->press('Atualizar Unidade');

            $browser->assertUrlIs(route('admin.units'));
            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Unidade atualizada com sucesso');
            });
            $browser->with('table.table', function ($table) use ($unitData) {
                $table->assertSee($unitData->name);
                $table->assertDontSee($this->unit->name);
            });
        });
    }

    public function testFailuteUpdate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.edit.unit', $this->unit->id));

            $browser->type('name', '')
                    ->type('address', '')
                    ->type('phone', '')
                    ->press('Atualizar Unidade');

            $browser->assertUrlIs(route('admin.show.unit', $this->unit->id));
            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Existem dados incorretos! Por favor verifique!');
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
            $browser->loginAs($this->user)->visit(route('admin.edit.unit', $this->unit->id));

            $browser->type('phone', '12')
                    ->press('Atualizar Unidade');

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Existem dados incorretos! Por favor verifique!');
            });

            $browser->with('div.unit_phone', function ($flash) {
                $flash->assertSee('O campo telefone deve ter pelo menos 10 caracteres.');
            });
        });
    }

    public function testUniquenessOnUpdate(): void
    {
         $this->browse(function ($browser) {
            $existingUnit = Unit::factory()->create();
            $browser->loginAs($this->user)->visit(route('admin.edit.unit', $this->unit->id));

            $browser->type('name', $existingUnit->name)
                    ->type('phone', $existingUnit->phone)
                    ->press('Atualizar Unidade');

            $browser->with('div.unit_name', function ($flash) {
                $flash->assertSee('O campo nome já está sendo utilizado.');
            });

            $browser->with('div.unit_phone', function ($flash) {
                $flash->assertSee('O campo telefone já está sendo utilizado.');
            });

            # Should update using the same values!
            $browser->type('name', $this->unit->name)
                    ->type('phone', $this->unit->phone)
                    ->press('Atualizar Unidade');

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Unidade atualizada com sucesso');
            });
         });
    }

    public function testAssertLinksPresent(): void
    {
        $this->unit = Unit::factory()->create();

        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.edit.unit', $this->unit->id));

            $backLinkSelector = "#main-card a[href='" . route('admin.units') . "']";
            $browser->assertSeeIn($backLinkSelector, 'Voltar');

            $rootBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.dashboard') . "']";
            $secondBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.units') . "']";
            $thirdBreadcrumbSelector = ".breadcrumb li:nth-child(3)";
            $browser->assertSeeIn($rootBreadcrumbSelector, 'Página Inicial');
            $browser->assertSeeIn($secondBreadcrumbSelector, 'Unidades');
            $browser->assertSeeIn($thirdBreadcrumbSelector, "Editar Unidade #{$this->unit->id}");
        });
    }
}
