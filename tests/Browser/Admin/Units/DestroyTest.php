<?php

namespace Tests\Browser\Admin\Units;

use App\Models\Unit;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DestroyTest extends DuskTestCase
{
    /** @var \App\Models\Unit */
    protected $unit;
    /** @var \App\Models\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->unit = Unit::factory()->create();
        $this->user = User::factory()->create();
    }

    public function testDestroy(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit('/admin/units');

            $browser->with("table.table tbody", function ($row) {
                $row->assertSee($this->unit->name);
                $row->click('button')
                    ->acceptDialog()
                    ->assertDontSee($this->unit->name);
            });
        });
    }
}
