<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    protected $table = 'trabajador';
    protected $primaryKey = 'id';
    protected $fillable = ['Hora', 'Cargo', 'Tipo', 'tutor_id'];

    /**
     * Relación inversa uno a uno con el modelo Tutor.
     */
    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    /**
     * Relación de uno a muchos con el modelo cuota
     */
    public function cuotas()
    {
        return $this->hasMany(Infante::class);
    }
}
