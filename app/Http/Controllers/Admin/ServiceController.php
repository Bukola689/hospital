<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Http\Resources\ServiceResource;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Repository\Admin\Service\ServiceRepository;
use Illuminate\Support\Facades\Cache;

class ServiceController extends Controller
{
    public $service;
    
    public function __construct(ServiceRepository $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $services = Cache::remember('services', now()->addDay(), function () {
            return Service::orderBy('id', 'desc')->paginate(5);
        });

        if($services->isEmpty()) {
            return response()->json('Service not found');
        }


        return ServiceResource::Collection($services);
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
     * @param  \App\Http\Requests\StoreServiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceRequest $request)
    {
        $data = $request->all();

        $this->service->saveService($request, $data);

        Cache::put('service', $data);

       return response()->json([
        'status' => true,
        'message' => 'Service Added Successfully !'
       ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json('Service Id Not Found');
        }

        $serviceShow = Cache::remember('service:'. $service->id, now()->addDay(), function () use ($service) {
            return $service;
        });
        
        if ($service) {
            return new ServiceResource($serviceShow);
    
           } else {
            return response()->json([
                'status' => false,
                'message' => 'No Service Found !'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceRequest  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequest $request,$id)
    {
        $service = Service::find($id);

       $data = $request->all();
        
       if (!$service) {
           return response()->json('Service Id Not Found');
       }

       $this->service->updateService($request, $service, $data);

       Cache::put('service', $data);
        
        return response()->json([
            'status' => true,
            'message' => 'Service Was Updated !'
           ]);
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json('Service Id Not Found');
        }

       $this->service->removeService($service);

       Cache::pull('service');

        return response()->json([
            'message' => 'Service Deleted Successfully'
        ]);
       
    }
}
