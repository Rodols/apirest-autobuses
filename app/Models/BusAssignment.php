<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusAssignment extends Model
{
    //use HasFactory;
   protected $table = 'bus_assignments';

   //Relacion de una asignacion a un usuario
   public function user(){
    return $this->hasOne('App\User','user_id');
   }

   //Relacion de una asignacion a un autobus
   public function bus(){
    return $this->hasOne('App\Bus', 'bus_id');
   }

   //Relacion de una ruta a un autobus
   public function route(){
    return $this->hasOne('App\Route', 'route_id');
   }


}
