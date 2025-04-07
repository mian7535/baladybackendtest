<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonComplete extends Model
{
    public function lesson()
    {
        return $this->belongsTo(Course::class, 'lesson_id');
    }
}
