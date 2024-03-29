<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class getAllServiceController extends Controller
{
    public function index()
    {
        $allService = Cache::remember('services', now()->addDay(), function () {
            return Service::orderBy('id', 'desc')->get();
        });

        return ServiceResource::collection($allService);
    }

    public function getServiceById($id)
    {
        //$post = 
         $service = service::find($id);

         $serviceShow = Cache::remember('service:'. $service->id, now()->addDay(), function () use ($service) {
            return Service::where('id', $service->id)->get();
        });

        // return new PostResource($post);
        return response()->json([
            'status' => true,
            'service' => $serviceShow
        ]);
    }

    public function searchService($search)
    {
        $service = Service::where('name', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->get();
        if($service) {
            return response()->json([
                'success' => true,
                'service' => $service
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'service not found'
            ]);
        }
    }
}
