<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Lesson extends Model
{
    use HasFactory;

    protected $appends = ['lesson_completed'];


    
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function images()
    {
        return $this->hasMany(LessonImage::class);
    }


    public function LessonComplete()
    {
        return $this->hasOne(LessonComplete::class,'lesson_id');
    }

    public function getLessonCompletedAttribute()
    {
	if($this->LessonComplete()->where('student_id',Auth::user()->id)->exists()){
        return 1;
	}else{
        return 0;
	}
    }
}