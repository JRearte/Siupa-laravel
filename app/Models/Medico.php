<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $table = 'medico';
    protected $primaryKey = 'id';
    protected $fillable = ['Tipo','Nombre','infante_id'];

    /**
     * Relación inversa uno a uno con el modelo infante
     */
    public function infante()
    {
        return $this->belongsTo(Infante::class);
    }
}
