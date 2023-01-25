<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisQuiz extends Model
{
    protected $table = 'jenis_quiz'; 
     protected $fillable =['id','jenis_quiz'];
}
