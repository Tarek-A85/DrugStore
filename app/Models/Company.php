<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable=['name'];
    protected $hidden=['id','created_at','updated_at','pivot'];
    public function medicines(){
        return $this->belongsToMany(Medicine::class);
    }
  
    public function commercial(){
        return $this->hasMany(CompanyMedicie::class)->with('calibers')->has('calibers');
    }
   
}
