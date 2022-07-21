<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\Area::factory(20)->create();

        DB::table('users')->insert([
            'name'      => 'José Fernando Pérez García',
            'email'     => 'josefernandoperezgarcia98@gmail.com',
            'estado'    => 'Si',
            'rol'       => 'Administrador',
            'password'  => bcrypt('123'),
        ]);
    }
}
