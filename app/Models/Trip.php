<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDO;

class Trip extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function bus(){

        return $this->belongsTo(Bus::class);
        
    }

    public function startStation(){

        return $this->belongsTo(Station::class, 'start_station_id');
        
    }
    public function endStation(){

        return $this->belongsTo(Station::class, 'end_station_id');
        
    }
}
