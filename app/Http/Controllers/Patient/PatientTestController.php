<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Http\Resources\TestResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PatientTestController extends Controller
{
    public function storeTest(Request $request)
    {
       $data = $request->validate([
            'name' => 'required',
            'service_id' => 'required',
            'room_id' => 'required',
        ]);

        $test = new Test;
        $test->name = $request->input('name');
        $test->service_id = $request->input('service_id');
        $test->room_id = $request->input('room_id');
        if(Auth::id())
        {
            $test->user_id = Auth::user()->id;
        }
        $test->status = 'processing';
        $test->save();

        Cache::put('test', $data);

        return new TestResource($test);
    }

    public function getTestId()
    {
      if(Auth::id())
      {
        $test = Cache::remember('test', now()->addDay(), function () {
             $user_id = Auth::user()->id;

            return Test::where('user_id', $user_id)->get(); 
        });
 
         return response()->json([
            'test' => $test
         ]);
      }
    }

    public function search($search)
    {
        $patientest = Test::where('name', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->get();
        if($patientest) {
            return response()->json([
                'success' => true,
                'patientest' => $patientest
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'patientest not found'
            ]);
        }
    }

}
