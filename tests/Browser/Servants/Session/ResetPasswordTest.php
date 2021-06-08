<?php

namespace Tests\Browser\Servants\Session;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Servant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordTest extends DuskTestCase
{
    /** @var \App\Models\Servant */
    protected $servant;

    public function setUp(): void
    {
        parent::setUp();
        $this->servant = Servant::factory()->create();
    }

    /**
     * A Dusk test link to reset password
     *
     * @return void
     */
    public function testLinkToResetPassword(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/servant/password/reset')
            ->type('email', $this->servant->email)
            ->click('.btn-block')
            ->assertPathIs('/servant/password/reset');

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Enviamos seu link de redefinição de senha por e-mail!');
            });
        });
    }

    /**
     * A Dusk test test change password
     *
     * @return void
    //  */
    public function testChangePassword(): void
    {
        $this->browse(function (Browser $browser) {
            $email = $this->servant->email;
            $createdAt = now();
            $token = Password::broker()->createToken($this->servant);
            $data = array('email' => $email,"token" => Hash::make($token),"created_at" => $createdAt);
            DB::table('password_resets')->insert($data);

            $link = '/servant/password/reset/' . $token . '?email=' . urlencode($email);

            /*Change password*/
            $browser->visit('/' . $link)
            ->type('password', 'password1')
            ->type('password_confirmation', 'password1')
            ->press('Modificar Senha')
            ->waitForLocation('/servant')
            ->click('div.header a.nav-link')
            ->clickLink('Sair');

            /*Check if the token is valid after modifying password*/
            $browser->visit('/' . $link)
            ->type('password', 'password1')
            ->type('password_confirmation', 'password1')
            ->press('Modificar Senha');

            $browser->with('span.invalid-feedback', function ($flash) {
                $flash->assertSee('Este token de redefinição de senha é inválido.');
            });

            /*Check if the user's password has been changed*/
            $browser->visit('/servant/login')
            ->type('CPF', $this->servant->CPF)
            ->type('password', 'password1')
            ->press('Entrar')
            ->assertPathIs('/servant');

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Login efetuado com sucesso.');
            });

            $browser->with('div.header', function ($header) {
                $header->assertSee($this->servant->name);
                $header->assertSee($this->servant->email);
            });
        });
    }
}
