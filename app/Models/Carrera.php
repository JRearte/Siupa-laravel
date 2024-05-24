<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $table = 'carrera';
    protected $primaryKey = 'id';
    protected $fillable = ['Codigo','Nombre','tutor_id'];

    /**
     * Relación uno a muchos con el modelo Asignatura.
     */
    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class);
    }

    /**
     * Relación inversa uno a uno con el modelo Tutor.
     */
    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }
}
