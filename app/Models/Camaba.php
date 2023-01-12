<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camaba extends Model
{
    protected $fillable = ['user_id','nama_camaba','tempat_lahir','tanggal_lahir','jenis_kelamin','wilayah','file_upload'];
    public function user(){
    	return $this->belongsTo(User::class);
    }
}
