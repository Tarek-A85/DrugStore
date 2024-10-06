<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caliber extends Model
{
    use HasFactory;
    protected $fillable=['company_medicine_id','caliber','price','quantity','total_quantity','expiration_date','status'];
    protected $hidden=['id','created_at','updated_at','company_medicine_id'];
    public function commercial(){
        return $this->belongsTo(CompanyMedicie::class,'company_medicine_id');
    }
}
