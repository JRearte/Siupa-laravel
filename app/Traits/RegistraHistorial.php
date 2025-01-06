<?php

namespace App\Traits;

use App\Models\Historial;

trait RegistraHistorial
{
    /**
     * Esta función permite registras una acción en el historial de usuario,
     * siendo esté reutilizado por todos los metodos CRUD de los controladores.
     *
     * @param int $id → identificador del usuario que realiza la acción.
     * @param string $accion → acción realizada (ejemplo: "Crear", "Editar", "Eliminar").
     * @param string|null $detalle → detalles adicionales sobre la acción.
     */
    public function registrarAccion(int $id, string $accion, string $detalle)
    {
        $fecha = now()->format('d/m/Y') . ' a las ' . now()->format('H:i');
        $detalle = "{$detalle} el día {$fecha}";
        Historial::create([
            'usuario_id' => $id,
            'accion' => $accion,
            'detalles' => $detalle,
        ]);
    }
}
