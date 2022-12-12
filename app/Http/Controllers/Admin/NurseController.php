<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nurse;
use App\Http\Resources\NurseResource;
use App\Http\Requests\StoreNurseRequest;
use App\Http\Requests\UpdateNurseRequest;
use App\Repository\Admin\Nurse\NurseRepository;

class NurseController extends Controller
{
    public $nurse;

    public function __construct(NurseRepository $nurse)
    {
        $this->nurse = $nurse;
    }
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
            
           $data = $request->all();

           $this->nurse->saveNurse($request, $data);
    
            return response()->json([
                'status' => 'Nurse Saved Successfully'
            ]); 
        
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
       
       $data = $request->all();

       $this->nurse->updateNurse($request,$nurse,$data);

      return response()->json([
        'status' => 'Nurse Updated Successfully'
      ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nurse  $nurse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nurse $nurse)
    {
        $this->nurse->removeNurse($nurse);

        return response()->json([
            'status' => 'Nurse Deleted Sucessfully'
        ]);
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
