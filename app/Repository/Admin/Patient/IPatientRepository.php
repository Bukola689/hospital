<?php 

namespace App\Repository\Admin\Patient;

use App\Models\Patient;
use Illuminate\Http\Request;

interface IPatientRepository
{
    public function savePatient(Request $request,array $data);

    public function updatePatient(Request $request,Patient $patient, array $data);

        public function removePatient(Patient $patient);
}