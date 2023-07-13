<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inpatient extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'inpatients';
    protected $fillable = ['doktor_id','hasta_id','oda_id','yatis_tarihi','yatis_nedeni','cikis_tarihi','yatis_durumu'];
    protected $dates = ['deleted_at'];

    public function inDoctor(){
        return $this->belongsTo(User::class,'doktor_id');
    }
    public function inPatient(){
        return $this->belongsTo(User::class,'hasta_id');
    }
    public function inRoom(){
        return $this->belongsTo(Room::class,'oda_id');
    }
}
