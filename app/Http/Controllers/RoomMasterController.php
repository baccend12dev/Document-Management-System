<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\AhuRoom;
class RoomMasterController extends Controller
{
    public function index(Request $request)
    {
        $serviceAreas = AhuRoom::select('service_area')->distinct()->whereNotNull('service_area')->pluck('service_area');
        $query = AhuRoom::query();

        // Search by room_name or room_code
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('room_name', 'LIKE', "%{$search}%")
                  ->orWhere('room_code', 'LIKE', "%{$search}%");
            });
        }

        if ($request->has('service_area') && $request->service_area != '') {
            $query->where('service_area', $request->service_area);
        }

        // Apply pagination
        $room = $query->paginate(10);
        return view('RoomMaster.index', compact('room', 'serviceAreas'));
    }

    public function create()
    {
        // Show the form for creating a new resource.
    }

    public function store(Request $request)
    {
        //room_code must be unique
        $room = AhuRoom::where('room_code', $request->room_code)->first();
        if ($room) {
            return redirect()->back()->with('error', 'Room code already exists.');
        }
        AhuRoom::create($request->all());
        return redirect()->back()->with('success', 'Room created successfully.');
    }

    public function show(int $id)
    {
        // Display the specified resource.
    }

    public function edit(int $id)
    {
        // Show the form for editing the specified resource.
    }

    public function update(Request $request, $id)
    {
        $room = AhuRoom::findOrFail($id);
        $room->update($request->all());

        return redirect()->back()->with('success', 'Room updated successfully.');
    }

    public function destroy($id)
    {
        $room = AhuRoom::findOrFail($id);
        $room->delete();

        return redirect()->back()->with('success', 'Room deleted successfully.');
    }
}

