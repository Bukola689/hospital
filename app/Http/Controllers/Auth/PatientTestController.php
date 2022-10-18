<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Http\Resources\TestResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PatientTestController extends Controller
{
    public function storeTest(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'service_id' => 'required',
            'ward_id' => 'required',
        ]);

        $test = new Test;
        $test->name = $request->input('name');
        $test->service_id = $request->input('service_id');
        $test->ward_id = $request->input('ward_id');
        if(Auth::id())
        {
            $test->user_id = Auth::user()->id;
        }
        $test->status = 'processing';
        $test->save();

        return new TestResource($test);
    }

    public function getTestId()
    {
      if(Auth::id())
      {
        $user_id = Auth::user()->id;

        $test = Test::where('user_id', $user_id)->get();
 
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
