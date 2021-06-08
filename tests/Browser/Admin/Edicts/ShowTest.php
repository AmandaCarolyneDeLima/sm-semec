<?php

namespace Tests\Browser\Admin\Edicts;

use App\Models\Edict;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ShowTest extends DuskTestCase
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

    public function testShow(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.show.edict', $this->edict->id));

            $browser->with('#main-card .card-body', function ($body) {
                $body->assertSee($this->edict->title);
                $body->assertSee($this->edict->description);
                $body->assertSee($this->edict->started_at->toShortDateTime());
                $body->assertSee($this->edict->ended_at->toShortDateTime());
            });
        });
    }

    public function testAssertLinksPresent(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.show.edict', $this->edict->id));

            $backLinkSelector = "#main-card a[href='" . route('admin.edicts') . "']";
            $editLinkSelector = "#main-card a[href='" . route('admin.edit.edict', $this->edict->id) . "']";
            $browser->assertSeeIn($backLinkSelector, 'Voltar');
            $browser->assertSeeIn($editLinkSelector, 'Editar');

            $rootBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.dashboard') . "']";
            $secondBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.edicts') . "']";
            $thirdBreadcrumbSelector = ".breadcrumb li:nth-child(3)";
            $browser->assertSeeIn($rootBreadcrumbSelector, 'Página Inicial');
            $browser->assertSeeIn($secondBreadcrumbSelector, 'Editais');
            $browser->assertSeeIn($thirdBreadcrumbSelector, "Edital #{$this->edict->id}");
        });
    }
}
