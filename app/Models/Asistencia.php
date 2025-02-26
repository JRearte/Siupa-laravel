<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Asistencia extends Model
{
    protected $table = 'asistencia';
    protected $primaryKey = 'id';
    protected $fillable = ['Fecha','Hora_Ingreso','Hora_Salida','Estado','Observacion','usuario_id','sala_id','infante_id'];

    protected $casts = [
        'Fecha' => 'date:Y-m-d',
        'Hora_Ingreso' => 'datetime:H:i',
        'Hora_Salida' => 'datetime:H:i',
    ];
    

    public function getHoraIngresoAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('H:i') : null;
    }
    
    public function getHoraSalidaAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('H:i') : null;
    }
    
    /**
     * Relación inversa uno a uno con el modelo Usuario
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    /**
     * Relación inversa uno a uno con el modelo Sala
     */
    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }

    /**
     * Relación inversa uno a uno con el modelo Infante
     */
    public function infante()
    {
        return $this->belongsTo(Infante::class);
    }
}
