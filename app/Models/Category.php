<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  
    use HasFactory;

      /**
       * Get the user associated with the Category
       *
       * @return \Illuminate\Database\Eloquent\Relations\HasOne
       */
      public function course()
      {
          return $this->hasOne(Course::class, 'category_id');
      }
}
