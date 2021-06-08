<?php

namespace Tests\Browser\Servants\Profile;

use Laravel\Dusk\Chrome;
use Tests\DuskTestCase;
use App\Models\Servant;
use Illuminate\Http\UploadedFile;

class ProfileUpdateTest extends DuskTestCase
{
    /** @var \App\Models\Servant */
    protected $servant;

    public function setUp(): void
    {
        parent::setUp();
        $this->servant = Servant::factory('servant')->create();
    }

    public function testProfiledUpdateSuccess(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->servant, 'servant')->visit('/servant');
            $browser->click('div.header a.nav-link')
                    ->clickLink('Meu Perfil')
                    ->type('name', 'Servidor1')
                    ->type('email', 'servant1@gmail.com')
                    ->attach('image', $this->servant->image = UploadedFile::fake()->image('avatar.png'))
                    ->type('current_password', 'password')
                    ->driver->executeScript('window.scrollTo(0, 400);');

                    $browser->press('Atualizar');

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Perfil atualizado com sucesso');
            });
        });
    }

    public function testProfiledUpdateFailure(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->servant, 'servant')->visit('/servant');
            $browser->click('div.header a.nav-link')
                    ->clickLink('Meu Perfil')
                    ->type('name', 'Servidor1')
                    ->type('email', 'servant1gmail.com')
                    ->attach('image', $this->servant->image = UploadedFile::fake()->image('avatar.png'))
                    ->type('current_password', 'password1')
                    ->driver->executeScript('window.scrollTo(0, 400);');

                    $browser->press('Atualizar');

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Existem dados incorretos! Por favor verifique!');
            });

            $browser->with('span.invalid-feedback', function ($error) {
                $error->assertSee('O campo email deve ser um endereço de e-mail válido.');
            });
        });
    }
}
