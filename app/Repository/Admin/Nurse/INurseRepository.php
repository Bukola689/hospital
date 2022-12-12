<?php 

namespace App\Repository\Admin\Nurse;

use App\Http\Requests\StoreNurseRequest;
use App\Models\Nurse;
use Illuminate\Http\Request;

interface INurseRepository
{
    public function saveNurse(Request $request,array $data);

     public function updateNurse(Request $request,Nurse $nurse, array $data);

     public function removeNurse(Nurse $nurse);
}