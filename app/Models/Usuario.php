<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as Authenticacion;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model implements Authenticacion
{
    use Authenticatable;

    protected $table = 'usuario';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['Legajo', 'Nombre', 'Apellido', 'Categoria', 'password', 'Habilitado'];
    protected $hidden = ['password', 'remember_token'];


    /**
     * Relación uno a muchos con el modelo Asistencia
     */
    public function asistencia()
    {
        return $this->hasMany(Asistencia::class);
    }

    /**
     * Relación uno a muchos con el modelo Historial
     */
    public function historiales()
    {
        return $this->hasMany(Historial::class, 'usuario_id');
    }
}
