<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Models\Nurse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class getAllNurseController extends Controller
{
    public function allNurse()
    {
        $allNurse = cache()->rememberForever('nurse:', function () {
            return Nurse::orderBy('id', 'desc')->get();

        });
        return response()->json([
            'success' => true,
            'allNurse' => $allNurse
        ]);
    }

    public function getNurseById($id)
    {

         $nurse = Cache::remember('nurse:'. $id, now()->addDay(), function () use ($id) {
            return  Nurse::where('id', $id)->get();;
        });

        return response()->json([
            'status' => true,
            'nurse' => $nurse
        ]);
    }

    public function searchNurse($search)
    {
        $nurse = Nurse::where('title', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->get();
        if($nurse) {
            return response()->json([
                'success' => true,
                'nurse' => $nurse
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'nurse not found'
            ]);
        }
    }
}
