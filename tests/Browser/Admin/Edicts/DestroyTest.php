<?php

namespace Tests\Browser\Admin\Edicts;

use App\Models\Edict;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DestroyTest extends DuskTestCase
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

    public function testDestroy(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit('/admin/edicts');

            $browser->with("table.table tbody", function ($row) {
                $row->assertSee($this->edict->title);
                $row->click('button')
                    ->acceptDialog()
                    ->assertDontSee($this->edict->title);
            });
        });
    }
}
