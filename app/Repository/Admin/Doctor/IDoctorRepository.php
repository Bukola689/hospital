<?php 

namespace App\Repository\Admin\Doctor;

use App\Http\Requests\StoreDoctorRequest;
use App\Models\Doctor;
use Illuminate\Http\Request;

interface IDoctorRepository
{
    public function allDoctor();

    public function saveDoctor(StoreDoctorRequest $request,array $data);

    public function updateDoctor(Request $request, Doctor $doctor, array $data);

    public function removeDoctor(Doctor $doctor);
}

?> 