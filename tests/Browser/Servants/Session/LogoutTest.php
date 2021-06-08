<?php

namespace Tests\Browser\Servants\Session;

use Laravel\Dusk\Chrome;
use Tests\DuskTestCase;
use App\Models\Servant;

class LogoutTest extends DuskTestCase
{
    public function testSuccessLogout(): void
    {
        $servant = Servant::factory()->create();
        $this->browse(function ($browser) use ($servant) {
            $browser->loginAs($servant, 'servant')->visit('/servant');
            $browser->click('div.header a.nav-link')
                    ->clickLink('Sair')
                    ->assertPathIs('/servant/login');
        });
    }
}
