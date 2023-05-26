<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Nurse;
use Illuminate\Http\Request;

class ViewNurseProfileController extends Controller
{
    public function viewSingleNurse(Nurse $nurse)
    {
        $nurseShow = Cache()->rememberForever('nurse:'. $nurse->id, now()->addDay(), function () use ($nurse) {
            return $nurse;
        });

         return response()->json($nurseShow);
       
    }
}
