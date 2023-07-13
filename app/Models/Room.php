<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $table = 'rooms';
    protected $fillable = [
        'oda_adi',
        'oda_numarasi',
        'yatak_sayisi',
        'bolum_id'
    ];
    public function department(){
        return $this->belongsTo(Department::class, 'bolum_id');
    }
}
