<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    //protected $fillable = ['ward_no',];

    public function test()
    {
        return $this->hasOne(Test::class);
    }
}
