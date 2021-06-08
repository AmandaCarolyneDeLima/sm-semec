<?php

namespace Tests\Unit\Traits;

use Tests\TestCase;
use Illuminate\Database\Eloquent\Model;
use App\Models\Edict;

class DateTimeFormatterTest extends TestCase
{

    public function testFormat(): void
    {
        $user = Edict::factory()->make();

        $user->started_at = '13/08/2020 01:54';
        $user->ended_at = '07/08/2020 01:54';
        $user->save();

        $user->refresh();

        $this->assertEquals($user->started_at->format('d/m/Y H:i'), '13/08/2020 01:54');
        $this->assertEquals($user->ended_at->format('d/m/Y H:i'), '07/08/2020 01:54');
    }
}
