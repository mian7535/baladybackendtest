<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseAnswar extends Model
{
    public function CourseQuestion()
    {
        return $this->belongsTo(CourseQuestion::class, 'course_question_id');
    }
}
