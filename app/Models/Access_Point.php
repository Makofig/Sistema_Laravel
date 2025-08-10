<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Access_Point extends Model
{
    // Nombre de la tabla
    protected $table = 'accesspoint';

    protected $fillable = [
        'ssid',
        'frecuencia',
        'ip_ap',
        'numcliente',
        'localidad'
    ];

    // Relación con el modelo de clientes uno a muchos
    public function clientes()
    {
        return $this->hasMany(Client::class, 'id_point');
    }
}
