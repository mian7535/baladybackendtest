<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'lesson_id'
    ];
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
