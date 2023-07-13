<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;
    protected $table = 'clinics';
    protected $fillable = [
        'klinik_adi',
        'klinik_numarasi',
        'bolum_id',
    ];
    public function department(){
        return $this->belongsTo(Department::class, 'bolum_id');
    }
    public function doctor(){
        return $this->hasMany(Doctor::class,'klinik_id');
    }
}
