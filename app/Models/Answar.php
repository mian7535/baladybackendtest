<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answar extends Model
{
    use HasFactory;

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }


    protected $hidden = [
        'correct',
    ];
}
