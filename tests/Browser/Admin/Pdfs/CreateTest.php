<?php

namespace Tests\Browser\Admin\Pdfs;

use App\Models\Edict;
use App\Models\User;
use App\Models\Pdf;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Http\UploadedFile;

class CreateTest extends DuskTestCase
{
    /** @var \App\Models\Edict */
    protected $edict;
    /** @var \App\Models\User */
    protected $user;
    /** @var \App\Models\Pdf */
    protected $pdf;

    public function setUp(): void
    {
        parent::setUp();
        $this->edict = Edict::factory()->create();
        $this->user = User::factory()->create();
    }

    public function testFailureCreate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.index.pdf', $this->edict->id));

            $browser->press('Adicionar PDF');

            $browser->with('span.invalid-feedback', function ($flash) {
                $flash->assertSee('O campo nome é obrigatório.');
            });

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Existem dados incorretos! Por favor verifique!');
            });
        });
    }

    public function testSuccessUploadPdf(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.index.pdf', $this->edict->id));

            $browser->type('name', 'Teste Pdf')
            ->attach('pdf', 'tests/files/pdfs/test.pdf')
            ->press('Adicionar PDF');

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('PDF adicionado com sucesso');
            });
        });
    }

    public function testWrongFile(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.index.pdf', $this->edict->id));
            $browser->type('name', 'example')
            ->attach('pdf', 'resources/images/logo.png')
            ->press('Adicionar PDF');

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Existem dados incorretos! Por favor verifique!');
            });
        });
    }
}
