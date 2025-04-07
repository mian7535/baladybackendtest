<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseMedia extends Model
{
    use HasFactory;

  public function course() {
        return $this->belongsTo(Category::class, 'course_id');
  }

  public function getVedioUrlAttribute() {
        return $this->attributes['vedio_url']."?raw=1";
  }

  public function getArVedioUrlAttribute() {
        return $this->attributes['ar_vedio_url']."?raw=1";
  }

  public function getUrVedioUrlAttribute() {
        return $this->attributes['ur_vedio_url']."?raw=1";
  }
}

