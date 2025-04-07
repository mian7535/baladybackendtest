<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    public function student()
    {
        return $this->belongsTo(Student::class,'student_id');
    }


    public function quiz()
    {
        return $this->belongsTo(Quiz::class,'quiz_id');
    }

}
