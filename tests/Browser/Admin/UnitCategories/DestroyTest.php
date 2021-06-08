<?php

namespace Tests\Browser\Admin\UnitCategories;

use App\Models\UnitCategory;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DestroyTest extends DuskTestCase
{
    /** @var \App\Models\UnitCategory */
    protected $category;
    /** @var \App\Models\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->category = UnitCategory::factory()->create();
        $this->user = User::factory()->create();
    }

    public function testDestroy(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit('/admin/unit-categories');

            $browser->with("table.table tbody", function ($row) {
                $row->assertSee($this->category->name);
                $row->click('button')
                    ->acceptDialog()
                    ->assertDontSee($this->category->name);
            });
        });
    }
}
