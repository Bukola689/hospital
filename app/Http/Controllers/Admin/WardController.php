<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use App\Http\Resources\WardResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wards = Cache::remember('wards', now()->addDay(), function () {
            return Ward::orderBy('id', 'desc')->get();
        });

        return WardResource::Collection($wards);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreWardRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ward = new Ward;
        $ward->room_no = $request->input('room_no');
        $ward->save();

        Cache::put('ward', $ward);

       return response()->json([
        'status' => true,
        'message' => 'Ward Added Successfully !'
       ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ward  $ward
     * @return \Illuminate\Http\Response
     */
    public function show(Ward $ward)
    {
        $wardShow = Cache::remember('ward:'. $ward->id, now()->addDay(), function () use ($ward) {
            return $ward;
        });

        if ($ward) {
            return new WardResource($wardShow);
    
           } else {
            return response()->json([
                'status' => false,
                'message' => 'No Ward Found !'
            ]);
    
           }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ward  $ward
     * @return \Illuminate\Http\Response
     */
    public function edit(Ward $ward)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateWardRequest  $request
     * @param  \App\Models\Ward  $ward
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ward $ward)
    {
        $ward->room_no = $request->input('room_no');
        $ward->update();

        Cache::put('ward', $ward);

       if($ward) {
       
            return new WardResource($ward);
           
       } else {
        return response()->json([
            'status' => false,
            'message' => 'Ward Was Not Updated !'
           ]);
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ward  $ward
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ward $ward)
    {
        $ward->delete();

        Cache::pull('ward');

        if($ward) {
         return response()->json([
             'status' => true,
             'ward' => 'Ward Deleted Successfully !'
         ]);
 
        } else {
         return response()->json([
             'status' => false,
             'message' => 'No Ward Found !'
         ]);
 
        }
    }
}
