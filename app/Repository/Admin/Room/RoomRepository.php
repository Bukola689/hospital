<?php 

namespace App\Repository\Admin\Room;

use App\Http\Requests\StoreRoomRequest;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomRepository implements IRoomRepository
{
    public function saveRoom(Request $request,array $data)
    {
        $room = new Room;
        $room->room_no = $request->input('room_no');
        $room->save();
    }

      public function updateRoom(Request $request,Room $room, array $data)
      {
        $room->room_no = $request->input('room_no');
        $room->update();

      }

      public function removeRoom(Room $room)
      {
        $room = $room->delete();
      }
}