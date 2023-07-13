<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'appointments';
    protected $fillable = ['doktor_id','hasta_id','randevu_tarihi','randevu_saati','randevu_durumu'];
    protected $dates = ['deleted_at'];

    public function appdoctor(){
        return $this->belongsTo(User::class,'doktor_id');
    }
    public function apppatient(){
        return $this->belongsTo(User::class,'hasta_id');
    }
}
