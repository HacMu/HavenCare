<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $table = 'doctors';
    protected $fillable = [
        'user_id',
        'doktor_tc',
        'doktor_adi',
        'doktor_cin',
        'doktor_adres',
        'doktor_tel',
        'doktor_dt',
        'doktor_uzmanlik',
        'klinik_id',
        'doktor_img',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function clinic(){
        return $this->belongsTo(Clinic::class, 'klinik_id');
    }
}
