<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Faker\Factory as Faker;

class UsuariosSeeder extends Seeder
{
    /**
     * Ejecuta las pruebas de base de datos : registro de usuarios.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $categorias = ['Coordinador', 'Maestro', 'Bienestar', 'Invitado'];

        // Crear un usuario predeterminado
        Usuario::create([
            'legajo' => '1-37202750/18',
            'Nombre' => 'Jonatan',
            'Apellido' => 'Rearte',
            'categoria' => 'Bienestar',
            'password' => bcrypt('37202750'),
            'habilitado' => true,
        ]);

        foreach (range(1, 50) as $index) {
            $legajo = sprintf('%d-%08d/%d', rand(1, 9), $faker->unique()->numberBetween(10000000, 99999999), rand(10, 99));

            Usuario::create([
                'legajo' => $legajo,
                'Nombre' => $faker->firstName,
                'Apellido' => $faker->lastName,
                'categoria' => $faker->randomElement($categorias),
                'password' => bcrypt('password'),
                'habilitado' => $faker->boolean,
            ]);
        }
    }
}

