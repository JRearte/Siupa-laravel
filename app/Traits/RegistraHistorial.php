<?php

namespace App\Traits;

use App\Models\Historial;

trait RegistraHistorial
{
    /**
     * Este método:
     * → Registra una acción en el historial de usuario.
     * → Almacena la acción realizada, los detalles y la fecha de la acción.
     * 
     * @param int $id → Identificador del usuario que realiza la acción.
     * @param string $accion → Acción realizada (ejemplo: "Crear", "Editar", "Eliminar").
     * @param string $detalle → Detalles adicionales sobre la acción realizada.
     * @return void → No retorna ningún valor.
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

    /**
     * Este método:
     * → Valida si el usuario autenticado tiene la categoría requerida para realizar la acción.
     * → Si no tiene permisos, lanza una excepción personalizada con el mensaje y la ruta especificados.
     * 
     * @param string $categoria → Categoría que el usuario debe tener para poder realizar la acción.
     * @param string $mensaje → Mensaje de error en caso de que el usuario no tenga permisos.
     * @param string $ruta → Ruta a la que se redirige si el usuario no tiene permisos.
     * @return void → No retorna ningún valor.
     * 
     * @throws \App\Exceptions\ValidacionException → Excepción lanzada si el usuario no tiene la categoría correcta.
     */
    public function validarPermiso(string $categoria, string $mensaje, string $ruta)
    {
        $usuarioAutenticado = auth()->user();
        if ($usuarioAutenticado->Categoria !== $categoria) {
            throw new \App\Exceptions\ValidacionException($mensaje, $ruta);
        }
    }
}