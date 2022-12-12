<?php 

namespace App\Repository\Admin\Service;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceRepository implements IServiceRepository
{
    public function saveService(Request $request,array $data)
    {
        $service = new Service;
        $service->name = $request->input('name');
        $service->save();
    }

       public function updateService(Request $request,Service $service, array $data)
       {
          $service->name = $request->input('name');
          $service->update();
       }

       public function removeService(Service $service)
       {
        $service = $service->delete();
       }
}