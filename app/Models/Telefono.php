<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telefono extends Model
{
    protected $table = 'telefono';
    protected $primaryKey = 'id';
    protected $fillable = ['Numero','tutor_id'];

    /**
     * Relación inversa uno a muchos con el modelo Tutor.
     */
    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }
}
