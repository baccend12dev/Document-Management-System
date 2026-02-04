<?php
// app/Http/Controllers/ToolsRegistrationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\EquipmentQualification;
use App\AhuRoom;

class ToolsRegistrationController extends Controller
    {
        // Mapping table ke sub-menu
        protected $tableMap = [
            'equipment' => 'QA_KKVequipment_qualifications',
        ];

        public function index()
        {
            $subMenus = $this->getSubMenus();

            return view('tools-registration.index', [
                'subMenus' => $subMenus        ]);
        }

        public function show(Request $request, $subMenu)
        {
            $subMenus = $this->getSubMenus();
            $serviceAreas = AhuRoom::select('service_area')->distinct()->get();

            // Query Builder
            $query = EquipmentQualification::where('sub_menu', $subMenu);

            // Filter: Building
            if ($request->has('building')) {
                $query->where('building', $request->building);
            }

            // Filter: Department
            if ($request->has('department')) {
                $query->where('department', $request->department);
            }

            // Filter: Search
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('equipment_id', 'LIKE', "%{$search}%")
                    ->orWhere('equipment_name', 'LIKE', "%{$search}%")
                    ->orWhere('product_code', 'LIKE', "%{$search}%")
                    ->orWhere('product_name', 'LIKE', "%{$search}%")
                    ->orWhere('systemName', 'LIKE', "%{$search}%")
                    ->orWhere('active_subtance', 'LIKE', "%{$search}%");
                });
            }


            $data = $query->paginate(10);
            
            $currentMenu = null;
            foreach ($subMenus as $menu) {
                if ($menu['id'] === $subMenu) {
                $currentMenu = $menu;
                break;
                }
            }
            $zatSubstans = EquipmentQualification::where('sub_menu', 'process-mediafill')->pluck('active_subtance')->unique()->toArray();
            
            if (!$currentMenu) {
                abort(404);
            }
            
            return view('tools-registration.' . $subMenu, [
                'subMenus' => $subMenus,
                'currentSubMenu' => $subMenu,
                'data' => $data,
                'currentMenu' => $currentMenu,
                'serviceAreas' => $serviceAreas,
                'zatSubstans' => $zatSubstans,
            ]);
        }

public function getRooms(Request $request)
{
    $rooms = AhuRoom::where('service_area', $request->serviceArea)
        ->select('room_name', 'room_code', 'ahu_code')
        ->distinct()
        ->orderBy('ahu_code')
        ->get();

    return response()->json($rooms);
}

    public function getSubMenus()
    {
        return [
            ['id' => 'equipment', 'label' => 'Equipment Qualification', 'icon' => '⚙️', 'category' => 'Qualification'],
            ['id' => 'utility', 'label' => 'Utility Qualification', 'icon' => '⚡', 'category' => 'Qualification'],
            ['id' => 'room', 'label' => 'Room Qualification', 'icon' => '🏢', 'category' => 'Qualification'],
            ['id' => 'computer', 'label' => 'Computerize System Validation', 'icon' => '💻', 'category' => 'Validation'],
            ['id' => 'process-mediafill', 'label' => 'Process & Mediafill Validation', 'icon' => '🧪', 'category' => 'Validation'],
            ['id' => 'cleaning', 'label' => 'Cleaning Validation', 'icon' => '🧹', 'category' => 'Validation'],
            ['id' => 'analytical-method', 'label' => 'Analytical Method', 'icon' => '📊', 'category' => 'Validation'],
        ];
    }




//get data from tools master dari calibration tools
// Controller function
public function checkEquipmentId(Request $request)
{
    try {
         $equipmentId = $request->input('equipment_id');
        
        // Cari data equipment berdasarkan id_column atau kode
        $equipment = DB::table('QA_calibrasi_tools')
            ->where('IdentityNumber', $equipmentId)
            ->first();
        
        if ($equipment) {
            return response()->json([
                'success' => true,
                'data' => $equipment,
                'message' => 'Equipment found'
            ]);
        } else {
    return response()->json([
        'success' => true,  // Tetap success: true
        'exists' => false,  // Tapi exists: false
        'data' => null,
        'message' => 'Equipment not found'
            ]); // Hapus status 404
        }
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}

    // Equipment
    public function storeEquipment(Request $request)
    {
        // dd($request->all());
        //check jika id_equipment dan sub_name sudah ada 
        $subMenu = $request->input('sub_menu');

        if (in_array($subMenu, ['equipment', 'computer'])) {
            if ($request->has('equipment_id') && !empty($request->equipment_id)) {
                $existing = EquipmentQualification::where('equipment_id', $request->equipment_id)
                    ->where('sub_menu', $subMenu)
                    ->first();

                if ($existing) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Equipment dengan ID ini dan Category sudah ada!');
                }
            }
        }

        if ($request->has('product_code') && !empty($request->product_code)) {
            $productExist = EquipmentQualification::where('product_code', $request->product_code)
                            ->where('sub_menu', $subMenu)
                            ->first();

            if ($productExist) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Product dengan Kode ini dan Category sudah ada!');
            }
        }

        if ($subMenu === 'room') {
            if ($request->has('service_area') && !empty($request->service_area)) {
                $productExist = EquipmentQualification::where('serviceArea', $request->service_area)
                                ->where('sub_menu', $subMenu)
                                ->first();

                if ($productExist) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Service Area dan Category sudah ada!');
                }
            }
        }


        $tools = EquipmentQualification::create([
            'equipment_id' => $request->input('equipment_id'),
            'product_code' => $request->input('product_code'),
            'equipment_name' => $request->input('equipment_name'),
            'product_name' => $request->input('product_name'),
            'building' => $request->input('building'),
            'department' => $request->input('department'),
            'dosageCode' => $request->input('dosageCode'),
            'active_subtance' => $request->input('active_subtance'),
            'no_batch' => $request->input('no_batch'),
            'roomName' => $request->input('roomName'),
            'roomNumber' => $request->input('roomNumber'),
            'location' => $request->input('location'),
            'serviceArea' => $request->input('service_area'),
            'systemName' => $request->input('system_name'),
            'type' => $request->input('type'),
            'model' => $request->input('model'),
            'serial_number' => $request->input('serial_number'),
            'sub_menu' => $request->input('sub_menu'),
            'created_by' => auth()->user()->username,
        ]);
        return redirect()->route('tools.show', $request->input('sub_menu'))->with('success', 'Equipment /Product data saved successfully!');
    }

    public function updateEquipment(Request $request, $id)
    {

    }

    //store mediafill
    public function storeMediafill(Request $request)
    {
        // Manual validation for Laravel 5.4 compatibility
        $products = $request->input('products');
        
        // Check if products array exists and has items
        if (!$products || !is_array($products) || count($products) < 1) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Please add at least one product before saving.');
        }

        $savedCount = 0;
        $errors = [];
        $subMenu = $request->input('sub_menu', 'process-mediafill');

        foreach ($products as $index => $productData) {
            // Validate required fields for each product
            if (empty($productData['product_code']) || 
                empty($productData['product_name']) || 
                empty($productData['type']) || 
                empty($productData['active_subtance']) || 
                empty($productData['building'])) {
                $errors[] = "Product at index " . ($index + 1) . " is missing required fields";
                continue;
            }

            // Check if product code already exists
            $existing = EquipmentQualification::where('product_code', $productData['product_code'])
                ->where('sub_menu', $subMenu)
                ->first();

            if ($existing) {
                $errors[] = "Product code {$productData['product_code']} already exists";
                continue;
            }

            try {
                // Create new product
                EquipmentQualification::create([
                    'product_code' => $productData['product_code'],
                    'product_name' => $productData['product_name'],
                    'type' => $productData['type'],
                    'dosageCode' => $productData['dosageCode'] ,
                    'active_subtance' => $productData['active_subtance'],
                    'building' => $productData['building'],
                    'no_batch' => $productData['no_batch'],
                    'sub_menu' => $subMenu,
                    'created_by' => auth()->user()->username,
                ]);

                $savedCount++;
            } catch (\Exception $e) {
                $errors[] = "Error saving product {$productData['product_code']}: " . $e->getMessage();
            }
        }

        // Prepare response message
        if ($savedCount > 0 && count($errors) === 0) {
            return redirect()->route('tools.show', $subMenu)
                ->with('success', "$savedCount product(s) saved successfully!");
        } elseif ($savedCount > 0 && count($errors) > 0) {
            return redirect()->route('tools.show', $subMenu)
                ->with('warning', "$savedCount product(s) saved. " . count($errors) . " failed: " . implode(', ', $errors));
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to save products: ' . implode(', ', $errors));
        }
    }

    public function destroy($id)
    {
        $equipment = EquipmentQualification::findOrFail($id);
        $equipment->delete();
        return back()->with('success', 'Data deleted successfully!');
    }

    // Get products by active substance for AJAX
    public function getProductsByActiveSubstance(Request $request)
    {
        try {
            $activeSubstance = $request->input('active_substance');
            
            if (!$activeSubstance) {
                return response()->json([
                    'success' => false,
                    'message' => 'Active substance is required'
                ], 400);
            }

            // Get products from process-mediafill that use this active substance
            $products = EquipmentQualification::where('sub_menu', 'process-mediafill')
                ->where('active_subtance', $activeSubstance)
                ->select('id', 'product_code', 'product_name', 'active_subtance', 'building')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $products,
                'message' => 'Products retrieved successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}