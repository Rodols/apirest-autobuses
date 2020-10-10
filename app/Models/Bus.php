<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
   // use HasFactory;
   protected $table = 'buses';

   //Relacion de muchos autobuses a un conductor
   public function user(){
    return $this->belongsTo('App\User','user_id');
   }

   //Relacion de muchos autobuses a una asignacion
   public function assignment(){
    return $this->belongsTo('App\BusAssignments', 'bus_id');
   }

}
