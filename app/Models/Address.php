<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable=['name','parent_id'];
    public function parent(){
        return $this->belongsTo(Address::class);
    }
    public function children(){
        return $this->hasMany(Address::class);
    }
}
