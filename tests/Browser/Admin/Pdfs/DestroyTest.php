<?php

namespace Tests\Browser\Admin\Pdfs;

use App\Models\Edict;
use App\Models\User;
use App\Models\Pdf;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DestroyTest extends DuskTestCase
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
        $this->pdf = Pdf::factory()->create();
    }

    public function testDestroy(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.index.pdf', $this->edict->id));
            $browser->loginAs($this->user)->visit('/admin/edicts/2/pdfs');

            $browser->with("table.table tbody", function ($row) {
                $row->assertSee($this->pdf->name);
                $row->click('button')
                    ->acceptDialog()
                    ->assertDontSee($this->pdf->name);
            });
        });
    }
}
