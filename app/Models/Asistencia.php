<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'asistencia';
    protected $primaryKey = 'id';
    protected $fillable = ['Fecha','Hora','Inasistencia','usuario_id','sala_id','infante_id'];

    /**
     * Relación inversa uno a uno con el modelo Usuario
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    /**
     * Relación inversa uno a uno con el modelo Sala
     */
    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }

    /**
     * Relación inversa uno a uno con el modelo Infante
     */
    public function infante()
    {
        return $this->belongsTo(Infante::class);
    }
}
