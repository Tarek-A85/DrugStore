<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
    protected $fillable=['order_id','caliber_id','quantity'];
    protected $hidden=['order_id','caliber_id','created_at','updated_at','id'];
    public function caliber(){
        return $this->belongsTo(Caliber::class)->with('commercial');
    }
}
