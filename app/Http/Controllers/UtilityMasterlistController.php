<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\ModelUtilityMasterlist;
use App\ModelUtilityDropdown;
use App\DocumentEquipment;
use Illuminate\Http\Request;

class UtilityMasterlistController extends Controller
{
    public function index()
    {
        $data = ModelUtilityMasterlist::orderBy('id', 'desc')->paginate(10);

        // Hardcoded dropdown options
        $subjects = ModelUtilityDropdown::pluck('subject')->toArray();
        $systems = ModelUtilityDropdown::pluck('system')->toArray();
        $models = ModelUtilityDropdown::pluck('model')->toArray();
        $buildings = ModelUtilityDropdown::pluck('building')->toArray();
        $locations = ModelUtilityDropdown::pluck('location')->toArray();
        $serviceareas = ModelUtilityDropdown::pluck('servicearea')->toArray();

        $roomNumbers = \DB::table('QA_KKVUtilityListRoom')->pluck('roomNumber')->toArray();
        $roomNames = \DB::table('QA_KKVUtilityListRoom')->pluck('roomName')->toArray();

        return view('utility.utilityMasterlist', compact(
            'data',
            'subjects',
            'systems',
            'models',
            'buildings',
            'locations',
            'serviceareas',
            'roomNumbers',
            'roomNames'
        ));
    }

    public function store(Request $request)
    {
        try {
            // Convert arrays to comma-separated strings
            $subject     = is_array($request->subject) ? implode(',', $request->subject) : $request->subject;
            $system      = is_array($request->system) ? implode(',', $request->system) : $request->system;
            $model       = is_array($request->model) ? implode(',', $request->model) : $request->model;
            $building    = is_array($request->building) ? implode(',', $request->building) : $request->building;
            $location    = is_array($request->location) ? implode(',', $request->location) : $request->location;
            $servicearea = is_array($request->servicearea) ? implode(',', $request->servicearea) : $request->servicearea;
            $roomNumber  = is_array($request->roomNumber) ? implode(',', $request->roomNumber) : $request->roomNumber;
            $roomName    = is_array($request->roomName) ? implode(',', $request->roomName) : $request->roomName;

            // Generate hash from all field values to detect duplicates
            $hashString = implode('|', [
                $subject, $system, $model, $building,
                $location, $servicearea, $roomNumber, $roomName
            ]);
            $hash = md5($hashString);

            // Check if this combination already exists
            $existing = ModelUtilityMasterlist::where('encrypt', $hash)->first();
            if ($existing) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Data dengan kombinasi yang sama sudah ada! (Duplicate detected)');
            }

            // Save new record
            ModelUtilityMasterlist::create([
                'subject'     => $subject,
                'system'      => $system,
                'model'       => $model,
                'building'    => $building,
                'location'    => $location,
                'servicearea' => $servicearea,
                'roomNumber'  => $roomNumber,
                'roomName'    => $roomName,
                'encrypt'     => $hash,
            ]);

            return redirect()->back()->with('success', 'Data berhasil disimpan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $record = ModelUtilityMasterlist::findOrFail($id);

            $subject     = is_array($request->subject) ? implode(',', $request->subject) : $request->subject;
            $system      = is_array($request->system) ? implode(',', $request->system) : $request->system;
            $model       = is_array($request->model) ? implode(',', $request->model) : $request->model;
            $building    = is_array($request->building) ? implode(',', $request->building) : $request->building;
            $location    = is_array($request->location) ? implode(',', $request->location) : $request->location;
            $servicearea = is_array($request->servicearea) ? implode(',', $request->servicearea) : $request->servicearea;
            $roomNumber  = is_array($request->roomNumber) ? implode(',', $request->roomNumber) : $request->roomNumber;
            $roomName    = is_array($request->roomName) ? implode(',', $request->roomName) : $request->roomName;

            // Generate new hash
            $hashString = implode('|', [
                $subject, $system, $model, $building,
                $location, $servicearea, $roomNumber, $roomName
            ]);
            $hash = md5($hashString);

            // Check duplicate (exclude current record)
            $existing = ModelUtilityMasterlist::where('encrypt', $hash)
                ->where('id', '!=', $id)
                ->first();

            if ($existing) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Data dengan kombinasi yang sama sudah ada! (Duplicate detected)');
            }

            $record->update([
                'subject'     => $subject,
                'system'      => $system,
                'model'       => $model,
                'building'    => $building,
                'location'    => $location,
                'servicearea' => $servicearea,
                'roomNumber'  => $roomNumber,
                'roomName'    => $roomName,
                'encrypt'     => $hash,
            ]);

            return redirect()->back()->with('success', 'Data berhasil diupdate!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    //detail utility to add document
    public function showDocument($id)
    {
        try {
            $utilitys = ModelUtilityMasterlist::with('utilityDocuments')->findOrFail($id);
            // dd($utilitys);
            return view('utility.utilityDocument', compact('utilitys'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $record = ModelUtilityMasterlist::findOrFail($id);
            $record->delete();

            return redirect()->back()->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}