<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{

    use HasFactory;
    protected $table = 'patients';
    protected $fillable = [
        'user_id',
        'hasta_tc',
        'hasta_adi',
        'hasta_cin',
        'hasta_adres',
        'hasta_tel',
        'hasta_kan_grubu',
        'hasta_kilo',
        'hasta_boyu',
        'hasta_dt',
        'hasta_image',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
