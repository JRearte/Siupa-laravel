<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    protected $table = 'sala';                                  // Nombre de la tabla en la base de datos.
    protected $primaryKey = 'id';                               // Nombre de la clave primaria de la tabla.
    protected $fillable = ['Nombre','Edad','Capacidad'];        // Constructor basado en Eloquent Model.

    /**
     * Relación uno a muchos con el modelo Infante
     */
    public function infante()
    {
        return $this->hasMany(Infante::class);
    }

    /**
     * Relación inversa muchos a muchos con el modelo Infante y las asistencia
     */
    public function infantes()
    {
        return $this->belongsToMany(Infante::class, 'asistencia');
    }

    /**
     * Relación uno a muchos con el modelo Asistencia
     */
    public function asistencia()
    {
        return $this->hasMany(Asistencia::class);
    }
}
