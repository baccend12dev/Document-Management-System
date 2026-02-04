<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\DocumentEquipment;
use App\DocumentHistory;
use Illuminate\Support\Facades\DB;
use App\Document;



class HistoryController extends Controller
{
    /**
     * Display history for a specific document
     */
    public function show($id)
    {
        // Get document with user relationship
        $document = DocumentEquipment::with('equipment')->findOrFail($id);
        
        // Get all history records for this document, ordered by newest first
        $histories = DocumentHistory::where('document_id', $id)
                    ->with('user')
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        return view('documents.historyDocument', compact('document', 'histories'));
    }

    /**
     * Store document history when updating
     * Call this method before updating document
     */
    public static function storeHistory(Document $document, Request $request)
    {
        DocumentHistory::create([
            'document_id' => $document->id,
            'doc_number' => $document->doc_number,
            'revision_number' => $request->revision_number ,
            'requalification' => $request->requalification ,
            'approve_date' => $request->approve_date ,
            'next_review' => $request->next_review ,
            'file_path' => $request->hasFile('file') ? $request->file('file')->store('documents', 'public') : $document->file_path,
            'remark' => $request->remark,
            'user_id' => auth()->id(),
        ]);
    }
}