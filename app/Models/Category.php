<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable=['name'];
    protected $hidden=['id','created_at','updated_at'];
    public function medicines(){
        return $this->hasMany(Medicine::class)->with('companies')->has('companies');
    }
    public function commercial(){
        return $this->hasManyThrough(CompanyMedicie::class,Medicine::class,'category_id','medicine_id')->with('calibers');
    }
    
  
}
