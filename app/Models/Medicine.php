<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;
    protected $fillable=['scientific_name','category_id'];
    protected $hidden=['id','created_at','updated_at','pivot','category_id'];
    public function category(){
        return $this->belongsTo(Category::class);
    }
   
    public function companies(){
        return $this->belongsToMany(Company::class)->with('commercial')->has('commercial')->distinct();
    }
   
   
    
    
}
