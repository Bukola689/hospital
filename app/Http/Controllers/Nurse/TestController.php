<?php

namespace App\Http\Controllers\Nurse;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Http\Resources\TestResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TestController extends Controller
{
    public function index()
    {
        $tests = Cache::remember('tests', now()->addDay(), function () {
            return Test::orderBy('id', 'desc')->get();
        });

        if($tests->isEmpty()) {
            return response()->json('Test is Empty');
        }

        return TestResource::Collection($tests);
    }

    

   
    public function updateTest(Request $request,  $id)
    {
        $test = Test::find($id);

        if(! $test) {
            return response()->json('Test Not Found');
        }
        
       if($test) {
        $test->status = $request->test['status'] ? 'Approved' : 'Processing' ;
        $test->update();

        Cache::put('test', $test);

        return new TestResource($test);

       }
    }

    public function removeTest(Test $test)
    {
         $test->delete();

         Cache::pull('test');

        return response()->json([
            'message' => true,
            'test' => 'TestRemoved Successfully !'
        ]);
    }
}
