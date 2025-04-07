<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lesson;

use Auth;

class Course extends Model
{
    use HasFactory;

    protected $appends = ['percentage'];

    /**
     * Get the user that owns the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'course_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function media()
    {
        return $this->hasOne(CourseMedia::class, 'course_id');
    }

    public function outcomes()
    {
        return $this->hasMany(CourseOutcome::class, 'course_id');
    }

    public function requirements()
    {
        return $this->hasMany(CourseRequirement::class, 'course_id');
    }

    public function CourseComplete()
    {
        return $this->hasOne(CourseComplete::class, 'course_id');
    }

    public function LessonComplete()
    {
        return $this->hasMany(LessonComplete::class, 'course_id');
    }


    public function Lesson()
    {
        return $this->hasMany(Lesson::class, 'course_id');
    }


    public function CourseQuestions()
    {
        return $this->hasMany(CourseQuestion::class, 'course_id');
    }


    public function getPercentageAttribute()
     {
	if($this->LessonComplete()->where('student_id',Auth::user()->id)->count() !== 0 ){
	return $this->attributes['percentage'] = $this->LessonComplete()->where('student_id',Auth::user()->id)->count() / $this->Lesson()->count() * 100;	
	}else{
	return $this->attributes['percentage'] = 0;
	}
        
     }


}
