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

         $addUser = 'add user';
         $editUser = 'edit user';
         $deleteUser = 'delete user';
 
         $addDoctor = 'add doctor';
         $editDoctor = 'edit doctor';
         $deleteDoctor = 'delete doctor';
 
         $addNurse = 'add nurse';
         $editNurse = 'edit nurse';
         $deleteNurse = 'delete nurse';
 
         $addPatient = 'add patient';
         $editPatient = 'edit patient';
         $deletePatient = 'delete patient';
 
         $addService = 'add service';
         $editService = 'edit service';
         $deleteService = 'delete service';
 
         $addRoom = 'add room';
         $editRoom = 'edit room';
         $deleteRoom = 'delete room';

         $addAppointment = 'add appointemnt';
         $editAppointment = 'edit appointment';
         $deleteAppointment = 'delete appointment';

         $addTest = 'add test';
         $editTest = 'edit test';
         $deleteTest = 'delete test';
 
 
         //user permisssion..//
         Permission::create(['name' => $addUser]);
         Permission::create(['name' => $editUser]);
         Permission::create(['name' => $deleteUser]);
 
         Permission::create(['name' => $addDoctor]);
         Permission::create(['name' => $editDoctor]);
         Permission::create(['name' => $deleteDoctor]);
 
         Permission::create(['name' => $addNurse]);
         Permission::create(['name' => $editNurse]);
         Permission::create(['name' => $deleteNurse]);
 
         Permission::create(['name' => $addPatient]);
         Permission::create(['name' => $editPatient]);
         Permission::create(['name' => $deletePatient]);
 
         Permission::create(['name' => $addService]);
         Permission::create(['name' => $editService]);
         Permission::create(['name' => $deleteService]);
 
         Permission::create(['name' => $addRoom]);
         Permission::create(['name' => $editRoom]);
         Permission::create(['name' => $deleteRoom]);

         Permission::create(['name' => $addTest]);
         Permission::create(['name' => $editTest]);
         Permission::create(['name' => $deleteTest]);

         Permission::create(['name' => $addAppointment]);
         Permission::create(['name' => $editAppointment]);
         Permission::create(['name' => $deleteAppointment]);
 
           //...Roles...//

           $superAdmin = 'super-admin';
           $doctor = 'doctor';
           $nurse = 'nurse';
           $patient = 'patient';

        Role::create(['name' => $superAdmin])->givePermissionTo(Permission::all());

        Role::create(['name' => $doctor])->givePermissionTo([
            $addDoctor,
            $editDoctor,
            $deleteDoctor,
            $addNurse,
            $editNurse,
            $deleteNurse,
            $addPatient,
            $editPatient,
            $deletePatient,
            $addService,
            $editService,
            $deleteService,
            $addRoom,
            $editRoom,
            $deleteRoom,
            $addAppointment,
            $editAppointment,
            $deleteAppointment,
            $addTest,
            $editTest,
            $deleteTest,
        ]);
 
         Role::create(['name' => $nurse])->givePermissionTo([
             $addPatient,
             $editPatient,
             $deletePatient,
             $addAppointment,
             $editAppointment,
             $deleteAppointment,
             $addTest,
             $editTest,
             $deleteTest,
         ]);
 
         Role::create(['name' => $patient])->givePermissionTo([
           
            $addAppointment,
            $addTest,
            
         ]);
    }
}
