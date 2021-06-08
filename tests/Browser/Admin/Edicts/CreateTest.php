<?php

namespace Tests\Browser\Admin\Edicts;

use App\Models\Edict;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateTest extends DuskTestCase
{
    /** @var \App\Models\Edict */
    protected $edict;
    /** @var \App\Models\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->edict = Edict::factory()->make([
            'started_at' => '28/07/2020 15:18',
            'ended_at' => '29/07/2020 15:18'
        ]);
        $this->user = User::factory()->create();
    }

    public function testSucessfullyCreate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.new.edict'));

            $browser->type('title', $this->edict->title)
                ->type('description', $this->edict->description)
                ->type('started_at', $this->edict->started_at->toShortDateTime())
                ->type('ended_at', $this->edict->ended_at->toShortDateTime())
                ->press('Criar Edital');

            $browser->assertUrlIs(route('admin.edicts'));
            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Edital cadastrado com sucesso');
            });
            $browser->with('table.table', function ($table) {
                $table->assertSee($this->edict->title);
            });
        });
    }

    public function testFailureUpdate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.new.edict'));

            $browser->press('Criar Edital');

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
            $browser->loginAs($this->user)->visit(route('admin.new.edict'));

            $browser->type('started_at', '28/07/2020 15:18')
                    ->type('ended_at', '27/07/2020 15:18')
                    ->press('Criar Edital');

            $browser->assertUrlIs(route('admin.edicts'));
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
            $browser->loginAs($this->user)->visit(route('admin.new.edict'));

            $backLinkSelector = "#main-card a[href='" . route('admin.edicts') . "']";
            $browser->assertSeeIn($backLinkSelector, 'Voltar');

            $rootBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.dashboard') . "']";
            $secondBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.edicts') . "']";
            $thirdBreadcrumbSelector = ".breadcrumb li:nth-child(3)";
            $browser->assertSeeIn($rootBreadcrumbSelector, 'Página Inicial');
            $browser->assertSeeIn($secondBreadcrumbSelector, 'Editais');
            $browser->assertSeeIn($thirdBreadcrumbSelector, "Novo Edital");
        });
    }
}
