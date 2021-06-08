<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::firstOrCreate([
            'email' => 'semec@gmail.com'
        ],[
            'name' => 'Administrador',
            'CPF' => '00000000000',
            'password' => '123456'
        ]);
    }
}
