<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Familia extends Model
{
    protected $table = 'familia';
    protected $primaryKey = 'id';
    protected $fillable = ['Nombre','Apellido','Vinculo','Fecha_de_nacimiento','Numero_documento','Tipo_documento','Lugar_de_trabajo','Ingreso','Habilitado','infante_id'];

    protected $casts = [
        'Fecha_de_nacimiento' => 'date',
    ];

    /**
     * Relación inversa uno a uno con el modelo Infante
     */
    public function infante()
    {
        return $this->belongsTo(Infante::class);
    }
}
