<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    protected $fillable=['user_id','caliber_id'];
    protected $hidden=['user_id','caliber_id','created_at','updated_at'];
    protected $append=['caliber_id'];
    public function caliber(){
        return $this->belongsTo(Caliber::class)->with('commercial');
    }
   
}
