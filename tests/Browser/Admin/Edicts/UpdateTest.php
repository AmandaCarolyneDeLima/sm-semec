<?php

namespace Tests\Browser\Admin\Edicts;

use App\Models\Edict;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UpdateTest extends DuskTestCase
{
    /** @var \App\Models\Edict */
    protected $edict;
    /** @var \App\Models\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->edict = Edict::factory()->create();
        $this->user = User::factory()->create();
    }

    public function testFilledFields(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.edit.edict', $this->edict->id));

            $browser->assertInputValue('title', $this->edict->title)
                    ->assertInputValue('description', $this->edict->description)
                    ->assertInputValue('started_at', $this->edict->started_at->toShortDateTime())
                    ->assertInputValue('ended_at', $this->edict->ended_at->toShortDateTime());
        });
    }

    public function testSucessfullyUpdate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.edit.edict', $this->edict->id));

            $newData = Edict::factory()->make([
                'started_at' => '28/07/2020 15:18',
                'ended_at' => '29/07/2020 15:18'
            ]);

            $browser->type('title', $newData->title)
                    ->type('description', $newData->description)
                    ->type('started_at', $newData->started_at->toShortDateTime())
                    ->type('ended_at', $newData->ended_at->toShortDateTime())
                    ->press('Atualizar Edital');

            $browser->assertUrlIs(route('admin.edicts'));
            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Edital atualizado com sucesso');
            });
            $browser->with('table.table', function ($table) use ($newData) {
                $table->assertSee($newData->title);
                $table->assertDontSee($this->edict->title);
            });
        });
    }

    public function testFailuteUpdate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.edit.edict', $this->edict->id));

            $browser->type('title', '')
                    ->type('description', '')
                    ->type('started_at', '')
                    ->type('ended_at', '')
                    ->press('Atualizar Edital');

            $browser->assertUrlIs(route('admin.show.edict', $this->edict->id));
            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Existem dados incorretos! Por favor verifique!');
            });

            $browser->with('div.edict_title', function ($flash) {
                $flash->assertSee('O campo Título é obrigatório.');
            });
            $browser->with('div.edict_description', function ($flash) {
                $flash->assertSee('O campo Descrição é obrigatório.');
            });
            $browser->with('div.edict_started_at', function ($flash) {
                $flash->assertSee('O campo Início é obrigatório.');
            });
            $browser->with('div.edict_ended_at', function ($flash) {
                $flash->assertSee('O campo Término é obrigatório.');
            });
        });
    }

    public function testDatesValidations(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.edit.edict', $this->edict->id));

            $browser->type('started_at', '28/07/2020 15:18')
                    ->type('ended_at', '27/07/2020 15:18')
                    ->press('Atualizar Edital');

            $browser->assertUrlIs(route('admin.show.edict', $this->edict->id));
            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Existem dados incorretos! Por favor verifique!');
            });

            $browser->with('div.edict_ended_at', function ($flash) {
                $flash->assertSee('O campo Término deve ser uma data posterior ou igual a Início.');
            });
        });
    }

    public function testAssertLinksPresent(): void
    {
        $this->edict = Edict::factory()->create();

        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.edit.edict', $this->edict->id));

            $backLinkSelector = "#main-card a[href='" . route('admin.edicts') . "']";
            $browser->assertSeeIn($backLinkSelector, 'Voltar');

            $rootBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.dashboard') . "']";
            $secondBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.edicts') . "']";
            $thirdBreadcrumbSelector = ".breadcrumb li:nth-child(3)";
            $browser->assertSeeIn($rootBreadcrumbSelector, 'Página Inicial');
            $browser->assertSeeIn($secondBreadcrumbSelector, 'Editais');
            $browser->assertSeeIn($thirdBreadcrumbSelector, "Editar Edital #{$this->edict->id}");
        });
    }
}
