<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = ['user_id','name','service_id','ward_id', 'status'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
