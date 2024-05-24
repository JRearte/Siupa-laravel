<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    protected $table = 'trabajador';
    protected $primaryKey = 'id';
    protected $fillable = ['Hora','Cargo','Tipo','tutor_id'];
    
    /**
     * Relación inversa uno a uno con el modelo Tutor.
     */
    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    /**
     * Relacion uno a mucho con el modelo Cuota
     */
    public function cuota()
    {
        return $this->hasMany(Cuota::class);
    }
}
