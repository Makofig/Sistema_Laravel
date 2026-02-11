<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Access_Point extends Model
{
    // Nombre de la tabla
    protected $table = 'accespoint';

    protected $fillable = [
        'ssid',
        'frecuencia',
        'ip_ap',
        'localidad'
    ];

    // Relación con el modelo de clientes uno a muchos
    public function clients()
    {
        return $this->hasMany(Client::class, 'id_point');
    }
}
