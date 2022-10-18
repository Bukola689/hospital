<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nurse;
use App\Http\Resources\NurseResource;
use App\Http\Requests\StoreNurseRequest;
use App\Http\Requests\UpdateNurseRequest;

class NurseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nurses = Nurse::orderBy('id', 'desc')->get();

        return NurseResource::Collection($nurses);
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
     * @param  \App\Http\Requests\StoreNurseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNurseRequest $request)
    {
            
            $request->validate([
                'user_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'd_o_b' => 'required',
                'phone' => 'required',
                'image' => 'required',
                'address' => 'required',
            ]);
    
            $image = $request->image;
      
            $originalName = $image->getClientOriginalName();
      
            $image_new_name = 'image-' .time() .  '-' .$originalName;
      
            $image->move('nurses/image', $image_new_name);
    
            $nurse = new Nurse;
            $nurse->user_id = $request->input('user_id');
            $nurse->first_name = $request->input('first_name');
            $nurse->last_name = $request->input('last_name');
            $nurse->d_o_b = $request->input('d_o_b');
            $nurse->phone = $request->input('phone');
            $nurse->image = 'nurses/image/' . $image_new_name;
            $nurse->address = $request->input('address');
            $nurse->save();
    
            return new NurseResource($nurse); 
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nurse  $nurse
     * @return \Illuminate\Http\Response
     */
    public function show(Nurse $nurse)
    {
        return new NurseResource($nurse);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nurse  $nurse
     * @return \Illuminate\Http\Response
     */
    public function edit(Nurse $nurse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNurseRequest  $request
     * @param  \App\Models\Nurse  $nurse
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNurseRequest $request, Nurse $nurse)
    {
        $request->validate([
            'user_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'd_o_b' => 'required',
            'phone' => 'required',
            'image' => 'required',
            'address' => 'required',
        ]);

        if( $request->hasFile('image')) {
  
            $image = $request->image;
  
            $originalName = $image->getClientOriginalName();
    
            $image_new_name = 'image-' .time() .  '-' .$originalName;
    
            $image->move('nurses/image', $image_new_name);
  
            $nurse->image = 'nurses/image/' . $image_new_name;
      }

      $nurse->user_id = $request->input('user_id');
      $nurse->first_name = $request->input('first_name');
      $nurse->last_name = $request->input('last_name');
      $nurse->d_o_b = $request->input('d_o_b');
      $nurse->phone = $request->input('phone');
      $nurse->room_id = $request->input('room_id');
      $nurse->service_id = $request->input('service_id');
      $nurse->address = $request->input('address');
      $nurse->update();

      return new NurseResource($nurse);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nurse  $nurse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nurse $nurse)
    {
        $nurse = $nurse->delete();

        return new NurseResource($nurse);
    }

    public function search($search)
    {
        $nurses = Nurse::where('first_name', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->get();
        if($nurses) {
            return response()->json([
                'success' => true,
                'nurses' => $nurses
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'nurses not found'
            ]);
        }
    }
}
