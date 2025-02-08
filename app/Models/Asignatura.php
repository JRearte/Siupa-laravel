<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    protected $table = 'asignatura';
    protected $primaryKey = 'id';
    protected $fillable = ['Codigo','Nombre','Fecha','Condicion','Calificacion','tutor_id','carrera_id'];

    protected $casts = [
        'Fecha' => 'date',
    ];

    /**
     * Relación inversa uno a muchos con el modelo Tutor.
     */
    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    /**
     * Relación inversa uno a muchos con el modelo Carrera.
     */
    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }
}

