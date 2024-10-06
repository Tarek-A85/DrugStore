<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;
    protected $fillable=['name','user_id','address_id'];
    protected $hidden=['address','user_id','created_at','updated_at','address_id'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function address(){
        return $this->belongsTo(Address::class);
    }
    public function orders(){
        return $this->hasMany(Order::class)->with('details')->has('details');
    }
    
}
