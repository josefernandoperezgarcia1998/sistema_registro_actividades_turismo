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
        // \App\Models\Area::factory(20)->create();

        DB::table('users')->insert([
            'name'      => 'José Fernando Pérez García',
            'email'     => 'josefernandoperezgarcia98@gmail.com',
            'estado'    => 'Si',
            'rol'       => 'Administrador',
            'password'  => bcrypt('123'),
        ]);

        DB::table('servicios')->insert([
            'nombre' => 'Mantenimiento',
            'estado' => 'Si',
        ]);
        DB::table('servicios')->insert([
            'nombre' => 'Página web',
            'estado' => 'Si',
        ]);
        DB::table('servicios')->insert([
            'nombre' => 'Asesoría',
            'estado' => 'Si',
        ]);
        DB::table('servicios')->insert([
            'nombre' => 'Servicio',
            'estado' => 'Si',
        ]);
        DB::table('servicios')->insert([
            'nombre' => 'Sistemas',
            'estado' => 'Si',
        ]);

        DB::table('users')->insert([
            'name' => 'Administrador',
            'email' => 'administrador@gmail.com',
            'password' => bcrypt('administrador'),
            'rol' => 'Administrador',
            'estado' => 'Si',
        ]);
        DB::table('users')->insert([
            'name' => 'José Fernando Pérez García',
            'email' => 'josefernando.sectur@gmail.com',
            'password' => bcrypt('123'),
            'rol' => 'Prestador',
            'estado' => 'Si',
        ]);
        DB::table('users')->insert([
            'name' => 'Alma Flor Lacorti Villatoro',
            'email' => 'almalacorti.sectur@gmail.com',
            'password' => bcrypt('12345678'),
            'rol' => 'Prestador',
            'estado' => 'Si',
        ]);
        DB::table('users')->insert([
            'name' => 'Andrea Estibaliz Mendez Rodas',
            'email' => 'andrea.secturui@gmail.com',
            'password' => bcrypt('12345678'),
            'rol' => 'Prestador',
            'estado' => 'Si',
        ]);
        DB::table('users')->insert([
            'name' => 'Berenice Carbot Gutierrez',
            'email' => 'bcarbot.sectur@gmail.com',
            'password' => bcrypt('12345678'),
            'rol' => 'Prestador',
            'estado' => 'Si',
        ]);
        DB::table('users')->insert([
            'name' => 'Carlos Alberto Navarro Perez',
            'email' => 'cnavarro.sectur@gmail.com',
            'password' => bcrypt('12345678'),
            'rol' => 'Prestador',
            'estado' => 'Si',
        ]);
        DB::table('users')->insert([
            'name' => 'Juan Pablo Prats Ovilla',
            'email' => 'jpratso.sectur@gmail.com',
            'password' => bcrypt('12345678'),
            'rol' => 'Prestador',
            'estado' => 'Si',
        ]);
        DB::table('users')->insert([
            'name' => 'Olgalidia Hernandez Velasco',
            'email' => 'olgalhv.sectur@gmail.com',
            'password' => bcrypt('12345678'),
            'rol' => 'Prestador',
            'estado' => 'Si',
        ]);
        DB::table('users')->insert([
            'name' => 'Sergio Santiago Sánchez Reynoso',
            'email' => 'santiago.sreynoso.sectur@gmail.com',
            'password' => bcrypt('12345678'),
            'rol' => 'Prestador',
            'estado' => 'Si',
        ]);
    }
}
