<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'first_name','last_name','d_o_b','phone','image','address',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
