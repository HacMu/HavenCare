<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = 'departments';
    protected $fillable = [
        'bolum_adi',
        'bolum_adres',
        'bolum_aciklama',
    ];
    public function clinic(){
        return $this->hasMany(Clinic::class,'bolum_id');
    }
    public function room(){
        return $this->hasMany(Room::class,'bolum_id');
    }

}
