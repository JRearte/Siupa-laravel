<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Infante extends Model
{
    protected $table = 'infante';
    protected $primaryKey = 'id';
    protected $fillable = ['Nombre','Apellido','Genero','Fecha_de_nacimiento','Numero_documento','Tipo_documento','Categoria','Fecha_de_asignacion','Habilitado','domicilio_id','tutor_id','sala_id'];

    /**
     * Relación inversa uno a uno con el modelo Domicilio
     */
    public function domicilio()
    {
        return $this->belongsTo(Domicilio::class);
    }

    /**
     * Relación inversa uno a uno con el modelo Tutor
     */
    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    /**
     * Relación inversa uno a uno con el modelo Sala
     */
    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }

    /**
     * Relación inversa muchos a muchos con el modelo Sala y las asistencia
     */
    public function salas()
    {
        return $this->belongsToMany(Sala::class, 'asistencia');
    }

    /**
     * Relación uno a muchos con el modelo Familia
     */
    public function familia()
    {
        return $this->hasMany(Familia::class);
    }

    /**
     * Relación uno a muchos con el modelo Medico
     */
    public function medico()
    {
        return $this->hasMany(Medico::class);
    }

    /**
     * Relación uno a muchos con el modelo Asistencia
     */
    public function asistencia()
    {
        return $this->hasMany(Asistencia::class);
    }

}
