<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = ['user_id',  'first_name','last_name','d_o_b','phone', 'room_id','image','service_id','address',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
