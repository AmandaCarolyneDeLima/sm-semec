<?php

namespace Tests\Browser\Servants\Profile;

use Laravel\Dusk\Chrome;
use Tests\DuskTestCase;
use App\Models\Servant;

class PasswordUpdateTest extends DuskTestCase
{
    /** @var \App\Models\Servant */
    protected $servant;

    public function setUp(): void
    {
        parent::setUp();
        $this->servant = Servant::factory()->create();
    }

    public function testPasswordUpdateSuccess(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->servant, 'servant')->visit('/servant');
            $browser->click('div.header a.nav-link')
                    ->clickLink('Alterar Senha')
                    ->type('current_password', 'password')
                    ->type('password', '12345678')
                    ->type('password_confirmation', '12345678')
                    ->press('Alterar senha');

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Senha alterada com sucesso');
            });

            $browser->click('div.header a.nav-link')
                    ->clickLink('Sair')
                    ->waitForLocation('/servant/login')
                    ->type('CPF', $this->servant->CPF)
                    ->type('password', '12345678')
                    ->press('Entrar')
                    ->waitForLocation('/servant')
                    ->assertSee('Login efetuado com sucesso.');
        });
    }

    public function testIncorrectCurrentPassword(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->servant, 'servant')->visit('/servant');
            $browser->click('div.header a.nav-link')
                    ->clickLink('Alterar Senha')
                    ->type('current_password', 'password1')
                    ->type('password', '12345678')
                    ->type('password_confirmation', '12345678')
                    ->press('Alterar senha');

            $browser->with('span.invalid-feedback', function ($flash) {
                $flash->assertSee('A senha atual está incorreta');
            });
        });
    }

    public function testPasswordDontMatch(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->servant, 'servant')->visit('/servant');
            $browser->click('div.header a.nav-link')
                    ->clickLink('Alterar Senha')
                    ->type('current_password', 'password')
                    ->type('password', '12345678')
                    ->type('password_confirmation', '123456789')
                    ->press('Alterar senha');

            $browser->with('span.invalid-feedback', function ($flash) {
                $flash->assertSee('O campo senha de confirmação não confere.');
            });
        });
    }
}
