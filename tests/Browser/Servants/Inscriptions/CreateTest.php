<?php

namespace Tests\Browser\Servants\Inscriptions;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Carbon\Carbon;
use App\Models\Edict;
use App\Models\Servant;
use App\Models\Contract;
use App\Models\Unit;
use App\Models\RemovalType;
use Illuminate\Support\Str;

class CreateTest extends DuskTestCase
{
    /** @var \App\Models\Servant */
    protected $servant;
    /** @var \App\Models\Edict */
    protected $edict;
    /** @var \App\Models\RemovalType */
    protected $removalTypes;
    /** @var \App\Models\Unit */
    protected $units;

    public function setUp(): void
    {
        parent::setUp();
        $this->servant = Servant::factory()->create();
        Contract::factory()->state(['servant_id' => $this->servant])->count(2)->create();

        $this->edict = Edict::factory()->state([
            'started_at' => Carbon::yesterday()->toShortDateTime(),
            'ended_at'   => Carbon::tomorrow()->toShortDateTime()])->create();

        $this->units = Unit::factory()->count(3)->create();
        $this->removalTypes = RemovalType::factory()->count(3)->create();
    }

    public function testRedirectWhenEdictIsExpiredForActionNew(): void
    {
        $this->edict->ended_at = Carbon::yesterday()->toShortDateTime();
        $this->edict->save();

        $this->browse(function ($browser) {
            $browser->loginAs($this->servant, 'servant')
                    ->visit(route('servant.new.inscription', $this->edict->id));

            $browser->assertUrlIs(route('servant.dashboard'));

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('A data limite das inscrições foi atingida!');
            });
        });
    }

    public function testRedirectWhenEdictIsExpiredForActionCreate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->servant, 'servant')
                    ->visit(route('servant.new.inscription', $this->edict->id));

            $this->edict->ended_at = Carbon::yesterday()->toShortDateTime();
            $this->edict->save();

            $browser->press('Enviar');
            $browser->assertUrlIs(route('servant.dashboard'));

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('A data limite das inscrições foi atingida!');
            });
        });
    }

    public function testSucessfullyCreate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->servant, 'servant')
                    ->visit(route('servant.new.inscription', $this->edict->id));

            $contract = $this->servant->contracts->first();
            $removalType = $this->removalTypes->random();
            $unit = $this->units->random();

            $browser->selectize('inscription_contract_id', $contract->id)
                    ->selectize('inscription_removal_type_id', $removalType->id)
                    ->selectize('inscription_interested_unit_id', $unit->id)
                    ->type('reason', 'work more')
                    ->press('Enviar');

            $browser->assertUrlIs(route('servant.dashboard'));
            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Inscrição realizada com sucesso!');
            });
        });
    }

    public function testFailureCreate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->servant, 'servant')
                    ->visit(route('servant.new.inscription', $this->edict->id));

            $browser->press('Enviar');

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Existem dados incorretos! Por favor verifique!');
            });

            $browser->with('div.inscription_contract_id', function ($flash) {
                $flash->assertSee('O campo contrato é obrigatório.');
            });
            $browser->with('div.inscription_removal_type_id', function ($flash) {
                $flash->assertSee('O campo tipo de remoção é obrigatório.');
            });
            $browser->with('div.inscription_interested_unit_id', function ($flash) {
                $flash->assertSee('O campo unidade de interesse é obrigatório.');
            });
            $browser->with('div.inscription_reason', function ($flash) {
                $flash->assertSee('O campo motivo é obrigatório.');
            });
        });
    }
}
