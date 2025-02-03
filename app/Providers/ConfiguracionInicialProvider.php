<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Usuario;
use App\Models\Sala;
use Illuminate\Support\Facades\Schema;

class ConfiguracionInicialProvider extends ServiceProvider
{
    /**
     * Realizar cualquier tarea de inicialización durante el arranque de la aplicación.
     *
     * @return void
     */
    public function boot()
    {
        if (Schema::hasTable('usuario') && Schema::hasTable('sala')) {
            if (!Usuario::where('id', 1)->exists()) {
                Usuario::create([
                    'Legajo' => '1-37202750/18',
                    'Nombre' => 'Jonatan',
                    'Apellido' => 'Rearte',
                    'Categoria' => 'Bienestar',
                    'password' => bcrypt('37202750'),
                    'Habilitado' => true,
                ]);
            }

            $salas = [
                ['id' => 1, 'Nombre' => 'Sala A', 'Edad' => 0, 'Capacidad' => 20],
                ['id' => 2, 'Nombre' => 'Sala B', 'Edad' => 1, 'Capacidad' => 20],
                ['id' => 3, 'Nombre' => 'Sala C', 'Edad' => 2, 'Capacidad' => 20]
            ];

            foreach ($salas as $sala) {
                if (!Sala::where('id', $sala['id'])->exists()) {
                    Sala::create($sala);
                }
            }
        }
    }

    /**
     * Registre servicios en la aplicación.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

