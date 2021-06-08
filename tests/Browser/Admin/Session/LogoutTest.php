<?php

namespace Tests\Browser\Admin\Session;

use App\Models\User;
use Laravel\Dusk\Chrome;
use Tests\DuskTestCase;

class LogoutTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testSucessLogout()
    {
        $user = User::factory()->create();
        $this->browse(function ($browser) use ($user) {
            $browser->loginAs($user)->visit('/admin');
            $browser->click('div.header a.nav-link')
                    ->clickLink('Sair')
                    ->assertPathIs('/admin/login');
        });
    }
}
