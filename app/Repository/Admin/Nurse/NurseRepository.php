<?php 

namespace App\Repository\Admin\Nurse;

use App\Http\Requests\StoreNurseRequest;
use App\Models\Nurse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NurseRepository implements INurseRepository
{
    public function saveNurse(Request $request,array $data)
    {
        $image = $request->image;
      
        $originalName = $image->getClientOriginalName();
  
        $image_new_name = 'image-' .time() .  '-' .$originalName;
  
        $image->move('nurses/image', $image_new_name);

        $nurse = new Nurse;
        $nurse->user_id = $request->input('user_id');
        $nurse->first_name = $request->input('first_name');
        $nurse->last_name = $request->input('last_name');
        $nurse->d_o_b = $request->input('d_o_b');
        $nurse->phone = $request->input('phone');
        $nurse->image = 'nurses/image/' . $image_new_name;
        $nurse->address = $request->input('address');
        $nurse->user_id = Auth::user()->id;
        $nurse->save();
    }

    public function updateNurse(Request $request,Nurse $nurse, array $data)
    {
        if( $request->hasFile('image')) {
  
            $image = $request->image;
  
            $originalName = $image->getClientOriginalName();
    
            $image_new_name = 'image-' .time() .  '-' .$originalName;
    
            $image->move('nurses/image', $image_new_name);
  
            $nurse->image = 'nurses/image/' . $image_new_name;
      }

      $nurse->user_id = Auth::user()->id;
      $nurse->first_name = $request->input('first_name');
      $nurse->last_name = $request->input('last_name');
      $nurse->d_o_b = $request->input('d_o_b');
      $nurse->phone = $request->input('phone');
      $nurse->address = $request->input('address');
      $nurse->update();
    }

    public function removeNurse(Nurse $nurse)
    {
        $nurse = $nurse->delete();
    }
}

?>