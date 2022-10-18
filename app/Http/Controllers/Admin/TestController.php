<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Http\Resources\TestResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::orderBy('id', 'desc')->get();

        return TestResource::Collection($tests);
    }

   
    public function updateTest(Request $request, Test $test)
    {
       if($test) {
        $test->status = $request->test['status'] ? 'Approved' : 'Processing' ;
        $test->update();

        return new TestResource($test);
       }
    }

    public function removeTest(Test $test)
    {
        $test = $test->delete();

        return response()->json([
            'message' => true,
            'test' => 'TestRemoved Successfully !'
        ]);
    }
}
