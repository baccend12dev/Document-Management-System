<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PIC;

class AdminController extends Controller
{
    public function listPIC(Request $request)
    {
        $search = $request->input('search');

        $pics = PIC::with([
            'picDocuments.document',
            'picDocuments.ccPic',
            'ccPicDocuments.document',
            'ccPicDocuments.pic'
        ])
        ->when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhereHas('picDocuments.document', function ($q) use ($search) {
                      $q->where('doc_number', 'like', "%{$search}%");
                  })
                  ->orWhereHas('ccPicDocuments.document', function ($q) use ($search) {
                      $q->where('doc_number', 'like', "%{$search}%");
                  });
        })
        ->get();

        return view('admin.listPIC', compact('pics', 'search'));
    }

    public function addPIC()
    {
        return view('admin.addPIC');
    }

    public function storePIC(Request $request)
    {
        $pic = new PIC();
        $pic->name = $request->name;
        $pic->email = $request->email;
        $pic->department = $request->department;
        $pic->section = $request->section;
        $pic->save();
        return redirect()->route('admin.list-pic');
    }

    //delete pic
    public function deletePIC($id)
    {
        $pic = PIC::find($id);
        $pic->delete();
        return redirect()->route('admin.list-pic');
    }

    // picDocuments method removed as documents are now shown in listPIC

    public function addPicDocument($id)
    {
        $pic = PIC::findOrFail($id);
        // Get IDs of documents already assigned to this PIC (either as Main PIC or CC PIC)
        $existingDocIds = \App\PicDocument::where('pic_id', $id)
            ->orWhere('ccpic_id', $id)
            ->pluck('document_id')
            ->unique();

        // Only documents that have next_review not null AND not already assigned to this PIC
        $documents = \App\DocumentEquipment::whereNotNull('next_review')
            ->whereNotIn('id', $existingDocIds)
            ->get();
        $ccpics = PIC::where('id', '!=', $id)->get();
        return view('admin.addPicDocument', compact('pic', 'documents', 'ccpics'));
    }

    public function storePicDocument(Request $request, $id)
    {
        $pic = PIC::findOrFail($id);
        $documentId = $request->document_id;
        $ccpicIds = $request->input('ccpic_id', []);

        // Delete existing assignments for this document & main PIC to avoid duplicates or to sync
        \App\PicDocument::where('pic_id', $pic->id)
            ->where('document_id', $documentId)
            ->delete();

        if (empty($ccpicIds)) {
            \App\PicDocument::create([
                'pic_id' => $pic->id,
                'document_id' => $documentId,
                'ccpic_id' => null,
            ]);
        } else {
            foreach ($ccpicIds as $ccId) {
                if (empty($ccId)) continue;
                \App\PicDocument::create([
                    'pic_id' => $pic->id,
                    'document_id' => $documentId,
                    'ccpic_id' => $ccId,
                ]);
            }
        }

        return redirect()->route('admin.list-pic')->with('success', 'Document added to PIC successfully.');
    }

    public function destroyPicDocument($pic_id, $doc_id)
    {
        // Find the record using its ID
        $picDoc = \App\PicDocument::findOrFail($doc_id);

        // Delete all rows for this assignment to delete the document and all its CCs
        \App\PicDocument::where('pic_id', $picDoc->pic_id)
            ->where('document_id', $picDoc->document_id)
            ->delete();
        
        return redirect()->route('admin.list-pic')->with('success', 'Document removed from PIC successfully.');
    }

    public function editPicDocument($pic_id, $doc_id)
    {
        $picDoc = \App\PicDocument::findOrFail($doc_id);
        $pic = PIC::findOrFail($pic_id);
        
        $document = \App\DocumentEquipment::findOrFail($picDoc->document_id);
        
        // Find all current CC PIC IDs assigned to this document under this main PIC
        $currentCcIds = \App\PicDocument::where('pic_id', $pic_id)
            ->where('document_id', $picDoc->document_id)
            ->whereNotNull('ccpic_id')
            ->pluck('ccpic_id')
            ->toArray();

        // Get all other PICs except the main PIC
        $allPics = PIC::where('id', '!=', $pic_id)->get();

        return view('admin.editPicDocument', compact('pic', 'picDoc', 'document', 'currentCcIds', 'allPics'));
    }

    public function updatePicDocument(Request $request, $pic_id, $doc_id)
    {
        $picDoc = \App\PicDocument::findOrFail($doc_id);
        $pic = PIC::findOrFail($pic_id);
        
        $ccpicIds = $request->input('ccpic_id', []);

        // Delete all rows for this assignment to reset
        \App\PicDocument::where('pic_id', $pic->id)
            ->where('document_id', $picDoc->document_id)
            ->delete();

        if (empty($ccpicIds)) {
            \App\PicDocument::create([
                'pic_id' => $pic->id,
                'document_id' => $picDoc->document_id,
                'ccpic_id' => null,
            ]);
        } else {
            foreach ($ccpicIds as $ccId) {
                if (empty($ccId)) continue;
                \App\PicDocument::create([
                    'pic_id' => $pic->id,
                    'document_id' => $picDoc->document_id,
                    'ccpic_id' => $ccId,
                ]);
            }
        }

        return redirect()->route('admin.list-pic')->with('success', 'CC PIC updated successfully.');
    }
}