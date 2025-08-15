<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contracts extends Model
{
    // nombre de la tabla 
    protected $table = 'plan'; 

    protected $fillable = [
        'nombre', 
        'megabytes',
        'costo'
    ]; 

    // Relación con el modelo cliente uno a muchos. 
    public function cliente()
    {
        return $this->hasMany(Client::class, 'id_plan');
    }
}
