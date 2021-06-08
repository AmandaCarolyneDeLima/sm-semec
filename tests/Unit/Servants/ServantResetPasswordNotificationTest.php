<?php

namespace Tests\Unit\Servants;

use Tests\TestCase;
use App\Models\Servant;
use Illuminate\Support\Facades\Password;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;

class ServantResetPasswordNotificationTest extends TestCase
{
    /** @var \App\Models\Servant */
    protected $servant;

    public function setUp(): void
    {
        parent::setUp();
        $this->servant = Servant::factory()->create();
        Notification::fake();
        Notification::assertNothingSent();

        //Notify the Servant that you need to use Notifiable.
        $this->servant->notify(new ResetPasswordNotification($this->servant));
    }

    public function tearDown(): void
    {
        $this->servant->delete();
    }

    public function testLinkToResetPassword(): void
    {
        //states that a specific type of notification was sent in accordance with the truth test provided
        Notification::assertSentTo(
            $this->servant,
            ResetPasswordNotification::class,
            function ($notification) {
                return $notification->token->email === $this->servant->email;
            }
        );

        //states that a notification was sent to users provided
        Notification::assertSentTo(
            [$this->servant],
            ResetPasswordNotification::class
        );
    }

    public function testEmailContent(): void
    {
        Notification::assertSentTo(
            $this->servant,
            ResetPasswordNotification::class,
            function ($notification) {
                $mailData = $notification->toMail($this->servant)->toArray();
                $text = "Este link de redefinição de senha expirará em 60 minutos.";

                $this->assertEquals("Notificação de redefinição de senha", $mailData['subject']);
                $this->assertEquals("Modificar Senha", $mailData['actionText']);
                $this->assertContains($text, $mailData['outroLines']);
                return $notification->token->email === $this->servant->email;
            }
        );
    }
}
