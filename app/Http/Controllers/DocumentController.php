<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ModelDocument;
use App\ToolsDocument;
use App\EquipmentQualification;
use App\UtilityQualification;
use App\RoomQualification;
use App\ComputerSystemValidation;
use App\ProcessSystemValidation;
use App\ProcessMediafillValidation;
use App\CleaningValidation;
use App\AnalyticalValidation;
use App\AnalyticalMethodValidation;
use Illuminate\Support\Facades\Storage;
use App\DocumentEquipment;
use Carbon\Carbon;
use App\DocumentHistory;
use App\Exports\DocumentsExport;
use Maatwebsite\Excel\Facades\Excel;

class DocumentController extends Controller
{
// Mapping sub-menu ke model
    // protected $modelMap = [
    //     'equipment' => EquipmentQualification::class,
    //     'utility' => UtilityQualification::class,
    //     'room' => RoomQualification::class,
    //     'computer' => ComputerSystemValidation::class,
    //     'process-mediafill' => ProcessMediafillValidation::class,
    //     'cleaning' => CleaningValidation::class,
    //     'analytical-method' => AnalyticalMethodValidation::class,
    // ];

    // Mapping sub-menu ke field untuk display
    protected $fieldMap = [
        'equipment' => [
            'id_field' => 'id',
            'display_field' => 'equipment_name',
            'id_column' => 'equipment_id',
            'building' => 'building',
            'dept' => 'department',
        ],
        'utility' => [
            'id_field' => 'id',
            'display_field' => 'equipment_name',
            'id_column' => 'equipment_id',
            'building' => 'building',
            'dept' => 'department',
        ],
        'room' => [
           'id_field' => 'id',
            'display_field' => 'serviceArea',
            'id_column' => 'location',
            'building' => 'building',
            'dept' => 'department',
        ],
        'computer' => [
            'id_field' => 'id',
            'display_field' => 'systemName',
            'id_column' => 'equipment_id',
            'building' => 'building',
            'dept' => 'department',
        ],
        'process-mediafill' => [
            'id_field' => 'id',
            'display_field' => 'product_name',
            'id_column' => 'product_code',
            'building' => 'building',
            'dept' => 'dosageCode',
        ],
        'cleaning' => [
            'id_field' => 'id',
            'display_field' => 'active_subtance',
            'id_column' => 'product_code',
            'building' => 'building',
            'dept' => 'dosageCode',
        ],
        'analytical-method' => [
            'id_field' => 'id',
            'display_field' => 'active_subtance',
            'id_column' => 'product_code',
            'building' => 'building',
            'dept' => 'product_name',
        ],
    ];

    // Document Type mapping dengan no_doc untuk setiap sub-menu dan type
    protected $documentTypeMap = [
        'equipment' => [
            ['type' => 'User Requirement Specification', 'no_doc' => ''],
            ['type' => 'Functional Design Specification', 'no_doc' => ''],
            ['type' => 'Design Specification', 'no_doc' => ''],
            ['type' => 'Risk Assessment', 'no_doc' => 'VAL-EQ/RSK'],
            ['type' => 'Installation Qualification Protocol', 'no_doc' => 'VAL-EQ/IQP'],
            ['type' => 'Operational Qualification Protocol', 'no_doc' => 'VAL-EQ/OQP'],
            ['type' => 'Performancance Qualification Protocol', 'no_doc' => 'VAL-EQ/PQP'],
            ['type' => 'Installation Qualification Report', 'no_doc' => 'VAL-EQ/IQR'],
            ['type' => 'Operational Qualification Report', 'no_doc' => 'VAL-EQ/OQR'],
            ['type' => 'Performance Qualification Report', 'no_doc' => 'VAL-EQ/PQR'],
            ['type' => 'Justification', 'no_doc' => 'VAL-EQ/JUS'],
            ['type' => 'Addendum', 'no_doc' => 'VAL-EQ/ADD'],
            ['type' => 'Periodic Review Report', 'no_doc' => 'VAL-EQ/PRR'],
            ['type' => 'Validation Study Protocol', 'no_doc' => 'VAL-EQ/STP'],
            ['type' => 'Validation Study Report', 'no_doc' => 'VAL-EQ/STR'],
        ],
        'utility' => [
            ['type' => 'User Requirement Specification', 'no_doc' => ''],
            ['type' => 'Functional Design Specification', 'no_doc' => ''],
            ['type' => 'Design Specification', 'no_doc' => ''],
            ['type' => 'Risk Assessment', 'no_doc' => 'VAL-UV/RSK'],
            ['type' => 'Installation Qualification Protocol', 'no_doc' => 'VAL-UV/IQP'],
            ['type' => 'Operational Qualification Protocol', 'no_doc' => 'VAL-UV/OQP'],
            ['type' => 'Performancance Qualification Protocol', 'no_doc' => 'VAL-UV/PQP'],
            ['type' => 'Installation Qualification Report', 'no_doc' => 'VAL-UV/IQR'],
            ['type' => 'Operational Qualification Report', 'no_doc' => 'VAL-UV/OQR'],
            ['type' => 'Performance Qualification Report', 'no_doc' => 'VAL-UV/PQR'],
            ['type' => 'Justification', 'no_doc' => 'VAL-UV/JUS'],
            ['type' => 'Addendum', 'no_doc' => 'VAL-UV/ADD'],
            ['type' => 'Periodic Review Report', 'no_doc' => 'VAL-UV/PRR'],
            ['type' => 'Validation Study Protocol', 'no_doc' => 'VAL-UV/STP'],
            ['type' => 'Validation Study Report', 'no_doc' => 'VAL-UV/STR'],
        ],
        'room' => [
            ['type' => 'User Requirement Specification', 'no_doc' => ''],
            ['type' => 'Functional Design Specification', 'no_doc' => ''],
            ['type' => 'Design Specification', 'no_doc' => ''],
            ['type' => 'Risk Assessment', 'no_doc' => 'VAL-RQ/RSK'],
            ['type' => 'Installation Qualification Protocol', 'no_doc' => 'VAL-RQ/IQP'],
            ['type' => 'Operational Qualification Protocol', 'no_doc' => 'VAL-RQ/OQP'],
            ['type' => 'Performancance Qualification Protocol', 'no_doc' => 'VAL-RQ/PQP'],
            ['type' => 'Installation Qualification Report', 'no_doc' => 'VAL-RQ/IQR'],
            ['type' => 'Operational Qualification Report', 'no_doc' => 'VAL-RQ/OQR'],
            ['type' => 'Performance Qualification Report', 'no_doc' => 'VAL-RQ/PQR'],
            ['type' => 'Justification', 'no_doc' => 'VAL-RQ/JUS'],
            ['type' => 'Addendum', 'no_doc' => 'VAL-RQ/ADD'],
            ['type' => 'Periodic Review Report', 'no_doc' => 'VAL-RQ/PRR'],
            ['type' => 'Validation Study Protocol', 'no_doc' => 'VAL-RQ/STP'],
            ['type' => 'Validation Study Report', 'no_doc' => 'VAL-RQ/STR'],
        ],
        'computer' => [
            ['type' => 'User Requirement Specification', 'no_doc' => ''],
            ['type' => 'Functional Design Specification', 'no_doc' => ''],
            ['type' => 'Design Specification', 'no_doc' => ''],
            ['type' => 'Validation Plan', 'no_doc' => 'VAL-CV/VP'],
            ['type' => 'Risk Assessment', 'no_doc' => 'VAL-CV/RSK'],
            ['type' => 'Installation Qualification Protocol', 'no_doc' => 'VAL-CV/IQP'],
            ['type' => 'Operational Qualification Protocol', 'no_doc' => 'VAL-CV/OQP'],
            ['type' => 'Installation Qualification Report', 'no_doc' => 'VAL-CV/IQR'],
            ['type' => 'Operational Qualification Report', 'no_doc' => 'VAL-CV/OQR'],
            ['type' => 'Validation Report', 'no_doc' => 'VAL-CV/VR'],
            ['type' => 'Justification', 'no_doc' => 'VAL-CV/JUS'],
            ['type' => 'Addendum', 'no_doc' => 'VAL-CV/ADD'],
            ['type' => 'Periodic Review Report', 'no_doc' => 'VAL-CV/PRR'],
            ['type' => 'Validation Study Protocol', 'no_doc' => 'VAL-CV/STP'],
            ['type' => 'Validation Study Report', 'no_doc' => 'VAL-CV/STR'],
        ],
        'process-mediafill' => [
            ['type' => 'Risk Assessment', 'no_doc' => 'VAL-VP/RSK'],
            ['type' => 'Validation Protocal', 'no_doc' => 'VAL-VP/PVP'],
            ['type' => 'Validation Report', 'no_doc' => 'VAL-VP/PVR'],
            ['type' => 'Justification', 'no_doc' => 'VAL-VP/JUS'],
            ['type' => 'Addendum', 'no_doc' => 'VAL-VP/ADD'],
            ['type' => 'Periodic Review Report', 'no_doc' => 'VAL-VP/PRR'],
            ['type' => 'Validation Study Protocol', 'no_doc' => 'VAL-VP/STP'],
            ['type' => 'Validation Study Report', 'no_doc' => 'VAL-VP/STR'],
        ],
        'cleaning' => [
            ['type' => 'Risk Assessment', 'no_doc' => 'VAL-CL/RSK'],
            ['type' => 'Validation Protocal', 'no_doc' => 'VAL-CL/CLP'],
            ['type' => 'Validation Report', 'no_doc' => 'VAL-CL/CLR'],
            ['type' => 'Justification', 'no_doc' => 'VAL-CL/JUS'],
            ['type' => 'Addendum', 'no_doc' => 'VAL-CL/ADD'],
            ['type' => 'Periodic Review Report', 'no_doc' => 'VAL-CL/PRR'],
            ['type' => 'Validation Study Protocol', 'no_doc' => 'VAL-CL/STP'],
            ['type' => 'Validation Study Report', 'no_doc' => 'VAL-CL/STR'],
        ],
        'analytical-method' => [
            ['type' => 'Risk Assessment', 'no_doc' => 'VAL-MC/RSK'],
            ['type' => 'Validation Protocal', 'no_doc' => 'VAL-MC/MCP'],
            ['type' => 'Validation Report', 'no_doc' => 'VAL-MC/MCR'],
            ['type' => 'Justification', 'no_doc' => 'VAL-MC/JUS'],
            ['type' => 'Addendum', 'no_doc' => 'VAL-MC/ADD'],
            ['type' => 'Periodic Review Report', 'no_doc' => 'VAL-MC/PRR'],
            ['type' => 'Validation Study Protocol', 'no_doc' => 'VAL-MC/STP'],
            ['type' => 'Validation Study Report', 'no_doc' => 'VAL-MC/STR'],
        ],
    ];


    public function index(Request $request)
    {
        $query = DocumentEquipment::with('equipment');

        // Filter by Category
        if ($request->has('category') && $request->category != '') {
            $query->where('sub_menu', $request->category);
        }

        // Filter by Document Type
        if ($request->has('doc_type') && $request->doc_type != '') {
            $query->where('document_type', $request->doc_type);
        }

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            
            $query->where(function($q) use ($searchTerm) {
                $q->where('doc_number', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhereHas('equipment', function($equipmentQuery) use ($searchTerm) {
                      $equipmentQuery->where('equipment_name', 'LIKE', '%' . $searchTerm . '%')
                                    ->orWhere('equipment_id', 'LIKE', '%' . $searchTerm . '%');
                  });
            });
        }

        // $documents = $query->get();
        $documents = $query->orderBy('id', 'desc')->paginate(10);
        // dd($documents);
        return view('documents.index', compact('documents'));
    }

    public function getSubMenus()
    {
        $subMenus = [
            [
                'id' => 'equipment',
                'label' => 'Equipment Qualification',
                'icon' => '⚙️',
                'category' => 'Qualification',
            ],
            [
                'id' => 'utility',
                'label' => 'Utility Qualification',
                'icon' => '⚡',
                'category' => 'Qualification',
            ],
            [
                'id' => 'room',
                'label' => 'Room Qualification',
                'icon' => '🏢',
                'category' => 'Qualification',
            ],
            [
                'id' => 'computer',
                'label' => 'Computerize System Validation',
                'icon' => '💻',
                'category' => 'Validation',
            ],
            [
                'id' => 'process-mediafill',
                'label' => 'Process & Mediafill Validation',
                'icon' => '🧪',
                'category' => 'Validation',
            ],
            [
                'id' => 'cleaning',
                'label' => 'Cleaning Validation',
                'icon' => '🧹',
                'category' => 'Validation',
            ],
            [
                'id' => 'analytical-method',
                'label' => 'Analytical Method Cleaning',
                'icon' => '📊',
                'category' => 'Validation',
            ]
        ];

        return response()->json($subMenus);
    }
    public function getDocumentTypes($subMenu)
    {
        // Langsung ambil dari documentTypeMap berdasarkan subMenu
        $types = $this->documentTypeMap[$subMenu];
        
        return response()->json($types);
    }

    public function getToolsBySubMenu($subMenu)
{
    try {
        $fieldConfig = $this->fieldMap[$subMenu] ;
        
        if (!$fieldConfig) {
            return response()->json([]);
        }

        // DEBUG: Cek data di database
        $tools = EquipmentQualification::with('documents')->where('sub_menu', $subMenu)->get();

        if ($tools->isEmpty()) {
            return response()->json([]);
        }

        $formattedTools = [];
        foreach ($tools as $tool) {
            $formattedTool = [
                'id' => $tool->{$fieldConfig['id_field']},
                'name' => $tool->{$fieldConfig['display_field']},
                'id_column' => $tool->{$fieldConfig['id_column']},
                'building' => $fieldConfig['building'] ? ($tool->{$fieldConfig['building']}) : null,
                'department' => $fieldConfig['dept'] ? ($tool->{$fieldConfig['dept']}) : null,
                //count documents
                'status' => $tool->documents->count() > 0 ? $tool->documents->count() : 'No',
            ];
            
            $formattedTools[] = $formattedTool;
        }

        \Log::info("Formatted tools for {$subMenu}:", $formattedTools);
        return response()->json($formattedTools);

    } catch (\Exception $e) {
        \Log::error('Error in getToolsBySubMenu: ' . $e->getMessage());
        return response()->json([]);
    }
}

    public function getDocumentTools($id, $subMenu)
    {
        try {
            // Ambil data dari Model DocumentTools
            $documents = DocumentEquipment::where('tools_id', $id)
                        ->where('sub_menu', $subMenu)
                        ->get();
            
            return response()->json([
                'success' => true,
                'data' => $documents,
                'message' => 'Data berhasil diambil'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

   public function store(Request $request)
    {
        // DD($request->all());
        $data = $request->all();
        
        // Split tools_id jika ada multiple tools (comma-separated)
        $toolIds = explode(',', $data['tools_id']);
        $toolIds = array_map('trim', $toolIds); // Remove whitespace
        
        // Check if document number already exists
        $existing = DocumentEquipment::where('doc_number', $data['document_number'])
        ->first();

    if ($existing) {
        return response()->json([
            'success' => false,
            'message' => 'Equipment dengan Document Number ini sudah ada ubah serial!',
            'data' => null
        ], 422); // HTTP 422 Unprocessable Entity
    }
        try {

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('documents', $fileName, 'public');
                $data['file_document'] = $filePath;
            } else {
                // \Log::error('No file uploaded in AJAX request');
                return response()->json([
                    'success' => false,
                    'message' => 'No file uploaded.'
                ], 422);
            }

            $createdDocuments = [];
            $createdHistories = [];
            
            // Loop untuk setiap tool yang dipilih
            foreach ($toolIds as $toolId) {
                $document = DocumentEquipment::create([
                    'tools_id' => $toolId,
                    'doc_number' => $data['document_number'],
                    'document_type' => $data['document_type'],
                    'sub_menu' => $data['sub_menu'],
                    'revision_number' => $data['revision_number'],
                    'requalification' => $data['requalification'],
                    'subject' => $data['subject'],
                    'modelType' => $data['modelType'],
                    'approved_date' => $data['approvedate'],
                    'next_review' => $data['nextreview'],
                    'review_frequency' => isset($data['review_frequency']) ? $data['review_frequency'] : null,
                    'file_path' => $data['file_document'],
                    'remarks' => $data['remarks'],
                    'created_by' => auth()->user()->username,   
                ]);
                
                $createdDocuments[] = $document;

                $history = DocumentHistory::create([
                    'document_id' => $document->id,
                    'doc_number' => $data['document_number'],
                    'revision_number' => $data['revision_number'],
                    'requalification' => $data['requalification'],
                    'approved_date' => $data['approvedate'],
                    'next_review' => $data['nextreview'],
                    'file_path' => $data['file_document'],
                    'remarks' => $data['remarks'],
                    'created_by' => auth()->user()->username,   
                ]);
                
                $createdHistories[] = $history;
            }
            
            $message = count($toolIds) > 1 
                ? 'Document uploaded successfully for ' . count($toolIds) . ' tools!'
                : 'Document uploaded successfully!';
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $createdDocuments,
                'count' => count($toolIds)
            ], 201);

        } catch (\Exception $e) {
            // \Log::error('Error in AJAX document upload', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 422);
        }
    }

    public function show($id)
    {
        
        $document = ToolsDocument::findOrFail($id);
        return response()->json($document);
    }

    public function MasterlistDocuments(Request $request)
    {
        // dd($request->all());
        $query = EquipmentQualification::with('documents');
        // Terapkan filter berdasarkan input pengguna
        if ($request->has('submenu') && $request->submenu != '') {
            $query->where('sub_menu', $request->submenu);
        }
        if ($request->has('department') && $request->department != '') {
            $query->where('department', $request->department);
        }
        if ($request->has('dosage_code') && $request->dosage_code != '') {
            $query->where('dosageCode', $request->dosage_code);
        }
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('equipment_id', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('product_code', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('equipment_name', 'LIKE', '%' . $searchTerm . '%');
            });
        }
       $perPage = request('per_page', 10); // Default to 10 if not set
        $tools = $query->paginate($perPage);


    // Hitung statistik

    // Opsi filter
    $submenuOptions = ['Equipment', 'Utility', 'Room', 'computer', 'cleaning', 'process-mediafill', 'analytical-method'];
    $statusOptions = ['Complete', 'Incomplete', 'Missing'];
    // dd($tools);
    return view('documents.masterlist',compact(
        'tools', 
        'submenuOptions'
    ));
    }
    public function destroy($id)
    {
        try {
            $document = DocumentEquipment::findOrFail($id);
            
            // Delete file from storage
            if (file_exists(storage_path('app/public/' . $document->file_path))) {
                unlink(storage_path('app/public/' . $document->file_path));
            }
            $document->delete();

            return response()->json([
                'success' => true,
                'message' => 'Document deleted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 422);
        }
    }
//update document
    public function update(Request $request)
    {
        // dd($request->all());
        try {
            // assume request contains 'id' of the document to update
            $id = $request->input('id');
            $document = DocumentEquipment::findOrFail($id);

            $document->doc_number = $request->input('doc_number');
            $document->revision_number = $request->input('revision_number');
            $document->requalification = $request->input('requalification');
            $document->approved_date = $request->input('approve_date');
            $document->next_review = $request->input('next_review');
            $document->remarks = $request->input('remark');
            $document->review_frequency = $request->input('frequency_review');
            $document->updated_by = auth()->user()->username;

            // jika ada file baru di-upload
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('documents', $fileName, 'public');

                // hapus file lama (opsional)
                if ($document->file_document && \Storage::disk('public')->exists($document->file_document)) {
                    \Storage::disk('public')->delete($document->file_document);
                }

                // simpan path baru
                $document->file_path = $filePath;
            }
            
            $document->save();

            // return view (no JSON, no validation)
            return redirect()->back()->with('success', 'Document updated successfully.');

        } catch (\Exception $e) {
            // on error return the same view with error message
            return redirect()->back()->with('error', 'Error updating document: ' . $e->getMessage());
        }
    }

//detail documenttools
    public function DetailDocument($id)
    {
        // dd($id);
        $document = EquipmentQualification::with('documents')->findOrFail($id);
        $subMenu = $document->sub_menu;
        $documentTypes = $this->documentTypeMap[$subMenu];
        // dd($documentTypes);
        // dd($document);
        return view('documents.detail', compact('document', 'documentTypes'));
    }
    public function viewDocument($id)
    {
        try {
            $document = DocumentEquipment::findOrFail($id);
            $filePath = storage_path('app/public/' . $document->file_path);
            
            if (!file_exists($filePath)) {
                \Log::error("File not found: " . $filePath);
                abort(404, 'File tidak ditemukan');
            }
            
            return response()->file($filePath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline'
            ]);
            
        } catch (\Exception $e) {
            \Log::error("Error viewing document: " . $e->getMessage());
            abort(404, 'Dokumen tidak dapat ditampilkan');
        }
    }

    public function downloadDocument($id)
{
    // dd($id);
    $document = DocumentEquipment::findOrFail($id);

    if (!$document->file_path || !\Storage::disk('public')->exists($document->file_path)) {
        return back()->with('error', 'File not found.');
    }

    $filePath = storage_path('app/public/' . $document->file_path);
    $fileName = basename($document->file_path);

    return response()->download($filePath, $fileName, [
        'Cache-Control' => 'no-cache, must-revalidate',
        'Pragma' => 'no-cache',
        'Expires' => '0',
    ]);

}


    public function schedule(Request $request)
    {
        // dd($request->all());
        // $query = DocumentEquipment::with('equipment');
        $query = DocumentEquipment::with('equipment')
        ->whereIn('document_type', [
            'Performance Qualification Report',
            'Operational Qualification Report',
            'Periodic Review',
            'Validation Report'
        ])
        ->whereNotNull('next_review');

        // Filter by Category
        if ($request->has('sub_menu') && $request->sub_menu != '') {
            $query->where('sub_menu', $request->sub_menu);
        }

        // Filter by Document Type
        if ($request->has('doc_type') && $request->doc_type != '') {
            $query->where('document_type', $request->doc_type);
        }

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            
            $query->where(function($q) use ($searchTerm) {
                $q->where('doc_number', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhereHas('equipment', function($equipmentQuery) use ($searchTerm) {
                      $equipmentQuery->where('equipment_name', 'LIKE', '%' . $searchTerm . '%')
                                    ->orWhere('equipment_id', 'LIKE', '%' . $searchTerm . '%');
                  });
            });
        }
        //priority by due date
        if ($request->has('priority') && $request->priority != '') {
        $query->where(function($q) use ($request) {
            switch ($request->priority) {
                case 'overdue':
                    $q->where('next_review', '<', Carbon::now());
                    break;
                case 'warning':
                    $q->whereBetween('next_review', [Carbon::now(), Carbon::now()->addDays(7)]);
                    break;
                case 'normal':
                    $q->whereBetween('next_review', [Carbon::now()->addDays(8), Carbon::now()->addDays(60)]);
                    break;
                case 'future':
                    $q->where('next_review', '>', Carbon::now()->addDays(60));
                    break;
            }
        });
    }
    // filter by month
        if ($request->has('start_month') && $request->has('end_month')) {

            $startMonth = Carbon::parse($request->start_month)->startOfMonth();
            $endMonth   = Carbon::parse($request->end_month)->endOfMonth();

            $query->whereBetween('next_review', [$startMonth, $endMonth]);
        }

            // Jika hanya ingin cek jumlah data (untuk cron)
        if ($request->has('count') && $request->count == 1) {
            return response()->json([
                'total' => $query->count()
            ]);
        }
        session(['duedateSchedule' => $query->get()]);
        $documents = $query->orderBy('id', 'desc')->paginate(10);
        $now = Carbon::now();
    //count data
        $subMenu = $request->sub_menu; 
        $showRoomfields = $subMenu === 'room';
        //session for print

        $countOverdue = $documents->filter(function ($doc) use ($now) {
            return Carbon::parse($doc->next_review)->isBefore($now);
        })->count();

        $countWarning = $documents->filter(function ($doc) use ($now) {
            $nextReview = Carbon::parse($doc->next_review);
            return $nextReview->greaterThanOrEqualTo($now) && $nextReview->lessThanOrEqualTo($now->copy()->addDays(7));
        })->count();

        $countNormal = $documents->filter(function ($doc) use ($now) {
            $nextReview = Carbon::parse($doc->next_review);
            return $nextReview->greaterThanOrEqualTo($now->copy()->addDays(8)) && $nextReview->lessThanOrEqualTo($now->copy()->addDays(60));
        })->count();

        $countFuture = $documents->filter(function ($doc) use ($now) {
            return Carbon::parse($doc->next_review)->isAfter($now->copy()->addDays(60));
        })->count();

        if ($request->has('print')) {
            $duedateSchedule = $query->orderBy('next_review', 'desc')->get();
            return view('reportLayout.duedateReport', compact('documents', 'duedateSchedule'));
        }


        // dd($documents);
        return view('documents.duedateschedule', compact('documents', 'duedateSchedule', 'showRoomfields', 'countOverdue', 'countWarning', 'countNormal', 'countFuture'));
    }

    //report by tools
    public function reportBytools( Request $request)
    {
        // dd($request->all());
        //search by tools
        $identityNumber = $request->search;
        $tools = EquipmentQualification::with('documents') 
                ->where('equipment_id', $identityNumber)
                ->get();
        // dd($tools);
        return view('documents.showbyTools', compact('tools'));
    }
    //report by Document
    public function reportByDoc(Request $request)
    {
        // dd($request->all());
        $query = DocumentEquipment::with('equipment');
        // Filter by Category
        if ($request->has('category') && $request->category != '') {
            // mapping kategori ke sub_menu yang termasuk di dalamnya          
                $query->where('sub_menu', $request->category);
        }
        // Filter by Document Type
        if ($request->has('document_type') && $request->document_type != '') {
            $query->where('document_type', $request->document_type);
        }
        // filter by building
        if ($request->has('building') && $request->building != '') {
            $query->whereHas('equipment', function($q) use ($request) {
                $q->where('building', $request->building);
            });
        }
        // filter by department
        if ($request->has('department') && $request->department != '') {
            $query->whereHas('equipment', function($q) use ($request) {
                $q->where('department', $request->department);
            });
        }
        // filter by dosage code
        if ($request->has('dosage') && $request->dosage != '') {
            $query->whereHas('equipment', function($q) use ($request) {
                $q->where('dosageCode', $request->dosage);
            });
        }
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            
            $query->where(function($q) use ($searchTerm) {
                $q->where('doc_number', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhereHas('equipment', function($equipmentQuery) use ($searchTerm) {
                      $equipmentQuery->where('equipment_name', 'LIKE', '%' . $searchTerm . '%')
                                    ->orWhere('equipment_id', 'LIKE', '%' . $searchTerm . '%')
                                    ->orWhere('product_code', 'LIKE', '%' . $searchTerm . '%');
                  });
            });
        }
        //session for print
        session(['reportByDocFilters' => $query->get()]);
        $documents = $query->orderBy('id', 'desc')->paginate(10);
        // dd($documents);
        return view('documents.showbyDoc', compact('documents'));
    }
    public function reportDocument(Request $request)
    {
        // dd($request->all());
        $documents = session('reportByDocFilters', []);
        $category = $request->input('category');

        // Use a single view for equipment-related categories
        if (in_array($category, ['equipment', 'room', 'utility', 'computer'])) {
            return view('reportLayout.equipment', compact('documents', 'category'));
        }

        // Other specific views
        if (in_array($category, ['process-mediafill', 'process-mediafil'])) {
            return view('reportLayout.process-mediafil', compact('documents'));
        } elseif ($category == 'cleaning') {
            return view('reportLayout.cleaning', compact('documents'));
        } elseif ($category == 'analytical-method') {
            return view('reportLayout.analytical-method', compact('documents'));
        } else {
            return redirect()->back()->with('error', 'Invalid category selected for report.');
        }

    }



    public function exportExcel(Request $request)
    {
        $documents = session('reportByDocFilters', []);
        $date = Carbon::now()->format('d-m-Y');
        $filename = "Document_Report_{$date}";

        $data = DocumentsExport::transform($documents);

        return Excel::create($filename, function($excel) use ($data) {
            $excel->sheet('Sheet1', function($sheet) use ($data) {
                $sheet->rows($data); # Use rows() to append the array data
                
                // Style header row
                $sheet->row(1, function($row) {
                    $row->setFontWeight('bold');
                });
            });
        })->download('xlsx');
    }
}