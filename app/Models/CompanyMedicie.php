<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyMedicie extends Model
{
    use HasFactory;
    protected $table='company_medicine';
    protected $fillable=['company_id','medicine_id','commercial_name'];
    protected $hidden=['company_id','medicine_id','created_at','updated_at','id','laravel_through_key'];
    public function calibers(){
        return $this->hasMany(Caliber::class,'company_medicine_id');
    }
    public function my_company(){
        return $this->belongsTo(Company::class,'company_id');
    }
    public function medicine(){
        return $this->belongsTo(Medicine::class);
    }
}
