<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = ['name'];

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function test()
    {
        return $this->hasMany(Test::class);
    }
}
