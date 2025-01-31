<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domicilio extends Model
{
    protected $table = 'domicilio';
    protected $primaryKey = 'id';
    protected $fillable = ['Provincia','Localidad','Codigo_postal','Barrio','Calle','Numero','tutor_id'];

    /**
     * Relación uno a uno con el modelo Tutor.
     */
    public function tutor()
    {
        return $this->hasOne(Tutor::class);
    }
    
    /**
     * Relación uno a uno con el modelo Infante.
     */
    public function infante()
    {
        return $this->hasone(Infante::class);
    }
}
