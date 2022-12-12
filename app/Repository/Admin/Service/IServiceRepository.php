<?php 

namespace App\Repository\Admin\Service;

use App\Models\Service;
use Illuminate\Http\Request;

interface IServiceRepository
{
    public function saveService(Request $request,array $data);

       public function updateService(Request $request,Service $service, array $data);

       public function removeService(Service $service);
}