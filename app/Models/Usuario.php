<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as Autentificacion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;


/**
 * Class Usuario
 *
 * @property $id
 * @property $Legajo
 * @property $Nombre
 * @property $Apellido
 * @property $Categoria
 * @property $password
 * @property $Habilitado
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Usuario extends Model implements Autentificacion
{
    use Authenticatable; 

    protected $table = 'usuario';
    protected $primaryKey = 'id';
    protected $perPage = 20;
    public $timestamps = true;


    protected $fillable = ['Legajo','Nombre','Apellido','Categoria','password','Habilitado'];
    protected $hidden = ['password','remember_token'];

    /**
     * Relación uno a muchos con el modelo Asistencia
     */
    public function asistencia()
    {
        return $this->hasMany(Asistencia::class);
    }
}
