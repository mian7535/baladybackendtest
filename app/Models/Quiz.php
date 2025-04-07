<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    public function section()
    {
        return $this->belongsTo(Section::class);
    }


    public function questions()
    {
        return $this->HasMany(Question::class, 'quiz_id');
    }


    public function certificate()
    {
        return $this->HasOne(Certificate::class,'quiz_id');
    }

}
