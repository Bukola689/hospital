<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // reset cached roles and permissions
         app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

         $accessUser = 'access user';
         $storeUser = 'store user';
         $showUser = 'show user';
         $updateUser = 'update user';
         $deleteUser = 'delete user';
 
         $accessDoctor = 'access doctor';
         $storeDoctor = 'store doctor';
         $showDoctor = 'show doctor';
         $updateDoctor = 'update doctor';
         $deleteDoctor = 'delete doctor';
 
         $accessNurse = 'access nurse';
         $storeNurse = 'store nurse';
         $showNurse = 'show nurse';
         $updateNurse = 'update nurse';
         $deleteNurse = 'delete nurse';
 
         $accessPatient = 'access patient';
         $storePatient = 'store patient';
         $showPatient = 'show patient';
         $updatePatient = 'update patient';
         $deletePatient = 'delete patient';
 
         $accessService = 'access service';
         $storeService = 'store service';
         $showService = 'show service';
         $updateService = 'update service';
         $deleteService = 'delete service';
 
         $accessRoom = 'access room';
         $storeRoom = 'store room';
         $showRoom = 'show room';
         $updateRoom = 'update room';
         $deleteRoom = 'delete room';

         $accessWard = 'access ward';
         $storeWard = 'store ward';
         $showWard = 'show ward';
         $updateWard = 'update ward';
         $deleteWard = 'delete ward';

         $accessAppointment = 'access appointment';
         $storeAppointment = 'store appointemnt';
         $showAppointment = 'show appointemnt';
         $updateAppointment = 'update appointment';
         $deleteAppointment = 'delete appointment';

         $accessTest = 'access test';
         $storeTest = 'store test';
         $showTest = 'show test';
         $showTest = 'show test';
         $updateTest = 'update test';
         $deleteTest = 'delete test';

         $getAllNurse = 'getAllNurse';
         $getAllDoctor = 'getAllDoctor';
         $getAllService = 'getAllService';
 
         $doctorProfile = 'doctor profile';
         $nurseProfile = 'nurse profile';
         $patientProfile = 'patient profile';
         $patientAppointment = 'patient appointment';
 
 
         //user permisssion..//
         Permission::create(['name' => $accessUser]);
         Permission::create(['name' => $storeUser]);
         Permission::create(['name' => $showUser]);
         Permission::create(['name' => $updateUser]);
         Permission::create(['name' => $deleteUser]);
 
         Permission::create(['name' => $accessDoctor]);
         Permission::create(['name' => $storeDoctor]);
         Permission::create(['name' => $showDoctor]);
         Permission::create(['name' => $updateDoctor]);
         Permission::create(['name' => $deleteDoctor]);
 
         Permission::create(['name' => $accessNurse]);
         Permission::create(['name' => $storeNurse]);
         Permission::create(['name' => $showNurse]);
         Permission::create(['name' => $updateNurse]);
         Permission::create(['name' => $deleteNurse]);
 
         Permission::create(['name' => $accessPatient]);
         Permission::create(['name' => $storePatient]);
         Permission::create(['name' => $showPatient]);
         Permission::create(['name' => $updatePatient]);
         Permission::create(['name' => $deletePatient]);
 
         Permission::create(['name' => $accessService]);
         Permission::create(['name' => $storeService]);
         Permission::create(['name' => $showService]);
         Permission::create(['name' => $updateService]);
         Permission::create(['name' => $deleteService]);
 
         Permission::create(['name' => $accessRoom]);
         Permission::create(['name' => $storeRoom]);
         Permission::create(['name' => $showRoom]);
         Permission::create(['name' => $updateRoom]);
         Permission::create(['name' => $deleteRoom]);

         Permission::create(['name' => $accessWard]);
         Permission::create(['name' => $storeWard]);
         Permission::create(['name' => $showWard]);
         Permission::create(['name' => $updateWard]);
         Permission::create(['name' => $deleteWard]);

         Permission::create(['name' => $accessTest]);
         Permission::create(['name' => $storeTest]);
         Permission::create(['name' => $showTest]);
         Permission::create(['name' => $updateTest]);
         Permission::create(['name' => $deleteTest]);

         Permission::create(['name' => $accessAppointment]);
         Permission::create(['name' => $storeAppointment]);
         Permission::create(['name' => $showAppointment]);
         Permission::create(['name' => $updateAppointment]);
         Permission::create(['name' => $deleteAppointment]);

         Permission::create(['name' => $getAllDoctor]);
         Permission::create(['name' => $getAllNurse]);
         Permission::create(['name' => $getAllService]);

         Permission::create(['name' => $doctorProfile]);
         Permission::create(['name' => $nurseProfile]);
         Permission::create(['name' => $patientProfile]);
         Permission::create(['name' => $patientAppointment]);
 
           //...Roles...//
 
           $doctor = 'doctor';
           $nurse = 'nurse';
           $patient = 'patient';

        Role::create(['name' => $doctor])->givePermissionTo(Permission::all());
 
         Role::create(['name' => $nurse])->givePermissionTo([
             $accessPatient,
             $storePatient,
             $showPatient,
             $updatePatient,
             $deletePatient,
             $accessService,
             $storeService,
             $showService,
             $updateService,
             $deleteService,
             $accessRoom,
             $storeRoom,
             $showRoom,
             $updateRoom,
             $deleteRoom,
             $accessWard,
             $storeWard,
             $showWard,
             $updateWard,
             $deleteWard,
             $accessAppointment,
             $storeAppointment,
             $showAppointment,
             $updateAppointment,
             $deleteAppointment,
             $accessTest,
             $storeTest,
             $showTest,
             $showTest,
             $updateTest,
             $deleteTest,
             $getAllNurse,
             $getAllDoctor,
             $getAllService,
             $doctorProfile,
             $nurseProfile,
             $patientProfile,
             $patientAppointment,
         ]);
 
         Role::create(['name' => $patient])->givePermissionTo([
           
            $accessPatient,
            $storePatient,
            $showPatient,
            $updatePatient,
            $deletePatient,
            $storeAppointment,
            $showAppointment,
            $storeTest,
            $showTest,
            $getAllNurse,
            $getAllDoctor,
            $getAllService,
            $doctorProfile,
            $nurseProfile,
            $patientProfile,
            $patientAppointment,
            
         ]);
    }
}
