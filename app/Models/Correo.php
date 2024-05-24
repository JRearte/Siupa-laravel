<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Correo extends Model
{
    protected $table = 'correo';
    protected $primaryKey = 'id';
    protected $fillable = ['Mail','tutor_id'];

    /**
     * Relación inversa de uno a muchos con el modelo Tutor
     */
    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }
}
