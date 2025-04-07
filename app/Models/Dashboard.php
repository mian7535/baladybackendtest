<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    use HasFactory;

 public function getVedioUrlAttribute()
    {
      return $this->attributes['vedio_url']."?raw=1";

    }

     public function getArVedioUrlAttribute()
    {
      return $this->attributes['ar_vedio_url']."?raw=1";

    }

     public function getUrVedioUrlAttribute()
    {
      return $this->attributes['ur_vedio_url']."?raw=1";

    }

}
