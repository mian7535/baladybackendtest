<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseQuestion extends Model
{
    public function QuestionOptions()
    {
        return $this->HasMany(CourseAnswar::class, 'course_question_id');
    }



    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
