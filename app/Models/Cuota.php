<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
    protected $table = 'cuota';
    protected $primaryKey = 'id';
    protected $fillable = ['Valor','Fecha','trabajador_id'];

    /**
     * Relación inversa uno a uno con el modelo Trabajador.
     */
    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }
}
