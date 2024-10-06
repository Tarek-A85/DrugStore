<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable=['pharmacy_id','price','status_id','paid'];
    protected $hidden=['status_id','pharmacy_id','created_at','updated_at'];
    public function pharmacy(){
        return $this->belongsTo(Pharmacy::class);
    }
    public function details(){
        return $this->hasMany(OrderDetails::class)->with('caliber');
    }
    public function status(){
        return $this->belongsTo(Status::class);
    }
}
