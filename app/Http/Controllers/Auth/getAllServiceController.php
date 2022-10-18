<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;

class getAllServiceController extends Controller
{
    public function index()
    {
        $allService = Service::orderBy('id', 'desc')->get();

        return ServiceResource::collection($allService);
    }

    public function getServiceById($id)
    {
        //$post = Post::find($id);
         $service = Service::where('id', $id)->get();

        // return new PostResource($post);
        return response()->json([
            'status' => true,
            'service' => $service
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
