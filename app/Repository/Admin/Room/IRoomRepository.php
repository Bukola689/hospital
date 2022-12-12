<?php 

namespace App\Repository\Admin\Room;

use App\Http\Requests\StoreRoomRequest;
use App\Models\Room;
use Illuminate\Http\Request;

interface IRoomRepository
{
    public function saveRoom(Request $request,array $data);

      public function updateRoom(Request $request,Room $room, array $data);

      public function removeRoom(Room $room);
}