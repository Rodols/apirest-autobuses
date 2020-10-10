<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusTravel extends Model
{
   //use HasFactory;
   protected $table = 'bus_travels';

   public function buses(){
    return $this->hasMany('App\bus_travels');
   }

   //Relacion de una asignacion a un autobus
   public function bus(){
    return $this->hasOne('App\Bus', 'bus_id');
   }

   //Relacion de una ruta a un autobus
   public function route(){
    return $this->hasOne('App\Route', 'route_id');
   }

   //Relacion de un parada a un autobus
   public function bus_stop(){
    return $this->hasOne('App\BusStop', 'bus_stop_id');
   }

}
