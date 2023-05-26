<?php

namespace App\Http\Controllers\Nurse;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Http\Resources\RoomResource;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Repository\Admin\Room\RoomRepository;
use Illuminate\Support\Facades\Cache;

class RoomController extends Controller
{
    public $room;

    public function __construct(RoomRepository $room)
    {
        $this->room = $room;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Cache::remember('rooms', now()->addDay(), function () {
            return Room::orderBy('id', 'desc')->paginate(5);
        });


        if($rooms->isEmpty()) {
            return response()->json('Rooms Is Empty');
        }
        return RoomResource::Collection($rooms);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRoomRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoomRequest $request)
    {
      
        $data = $request->all();

        $this->room->saveRoom($request, $data);

        Cache::put('room', $data);

       return response()->json([
        'status' => true,
        'message' => 'Room Added Successfully !'
       ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room = Room::find($id);

        if(! $room) {
            return response()->json('Room Id Not Found');
        }

        $roomShow = Cache()->remember('room:'. $room->id, now()->addDay(), function () use ($room) {
            return $room;
        });

       if ($room) {
        return new RoomResource($roomShow);

       } else {
        return response()->json([
            'status' => false,
            'message' => 'No Room Found !'
        ]);

       }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoomRequest  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoomRequest $request,  $id)
    {
        $room = Room::find($id);

        if(! $room) {
            return response()->json('Room Id Not Found');
        }

        $data = $request->all();

        $this->room->updateRoom($request, $room, $data);

        Cache::put('room', $data);
     
        return response()->json([
            'status' => true,
            'message' => 'Room Was Not Updated !'
           ]);
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room = Room::find($id);

        if(! $room) {
            return response()->json('Room Id Not Found');
        }

       $this->room->removeRoom($room);

       Cache::pull('room');

        return response()->json([
            'status' => true,
            'room' => 'Room Deleted Successfully !'
        ]);

    }
}
