<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nurse;
use App\Http\Resources\NurseResource;
use App\Http\Requests\StoreNurseRequest;
use App\Http\Requests\UpdateNurseRequest;
use App\Repository\Admin\Nurse\NurseRepository;
use Illuminate\Support\Facades\Cache;

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
        $nurses = cache()->rememberForever('nurse:all', function () {
            return  Nurse::orderBy('id', 'desc')->get();
        });

        if($nurses->isEmpty()) {
            return response()->json('Nurse Not Found');
        }

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

           Cache::put('nurse', $data);
    
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
    public function show( $id)
    {
        $nurse = Nurse::find($id);

        if(! $nurse) {
            return response()->json('Nurse Not Found');
        }

        $nurseShow = Cache::remember('nurse:'. $nurse->id, now()->addDay(), function () {
            return  Nurse::orderBy('id', 'desc')->get();
        });

        return new NurseResource($nurseShow);
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
    public function update(UpdateNurseRequest $request, $id)
    {
        $nurse = Nurse::find($id);

        if(! $nurse) {
            return response()->json('Nurse Not Found');
        }

       $data = $request->all();

       $this->nurse->updateNurse($request,$nurse,$data);

       Cache::put('nurse', $data);

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
    public function destroy($id)
    {
        $nurse = Nurse::find($id);

        if(! $nurse) {
            return response()->json('Nurse Not Found');
        }

        $this->nurse->removeNurse($nurse);

        Cache::pull('nurse');

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
