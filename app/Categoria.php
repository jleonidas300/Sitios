<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    //Leer las rutas por el slug y no el id
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // //relacioin de 1:n hacia establecimientos
    // public function establecimientos()
    // {
    //     return $this->hasMany(Establecimiento::class);
    // }
}
