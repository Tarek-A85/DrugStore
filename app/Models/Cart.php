<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable=['commercial_name','caliber','quantity','user_id'];
    protected $hidden=['created_at','updated_at','user_id'];
}
