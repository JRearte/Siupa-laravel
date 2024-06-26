<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    protected $table = 'tutor'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id'; // Nombre de la clave primaria en la tabla
    protected $fillable = ['Legajo','Nombre','Apellido','Genero','Fecha_de_nacimiento','Numero_documento','Tipo_documento','Tipo_tutor','Habilitado','domicilio_id'];

    /**
     * Relación inversa uno a uno con el modelo Domicilio.
     */
    public function domicilio()
    {
        return $this->belongsTo(Domicilio::class);
    }

    /**
     * Relación uno a muchos con el modelo Asignatura.
     */
    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class);
    }

    /**
     * Relación uno a uno con el modelo Carrera.
     */
    public function carrera()
    {
        return $this->hasOne(Carrera::class);
    }

    /**
     * Relación uno a uno con el modelo Trabajador.
     */
    public function trabajador()
    {
        return $this->hasOne(Trabajador::class);
    }

    /**
     * Relación uno a muchos con el modelo Telefono.
     */
    public function telefonos()
    {
        return $this->hasMany(Telefono::class);
    }

    /**
     * Relación de uno a muchos con el modelo Correo.
     */
    public function correo()
    {
        return $this->hasMany(Correo::class);
    }

    /**
     * Relación de uno a muchos con el modelo Infante
     */
    public function infante()
    {
        return $this->hasMany(Infante::class);
    }

}