<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PIC;

class AdminController extends Controller
{
    public function listPIC(Request $request)
    {
        $search = $request->input('search');

        $pics = PIC::with(['picDocuments.document', 'picDocuments.ccPic'])
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhereHas('picDocuments.document', function ($q) use ($search) {
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
        // Get IDs of documents already assigned to this PIC
        $existingDocIds = \App\PicDocument::where('pic_id', $id)->pluck('document_id');

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
        
        \App\PicDocument::create([
            'pic_id' => $pic->id,
            'document_id' => $request->document_id,
            'ccpic_id' => $request->ccpic_id, // can be null
        ]);

        return redirect()->route('admin.list-pic')->with('success', 'Document added to PIC successfully.');
    }

    public function destroyPicDocument($pic_id, $doc_id)
    {
        $picDoc = \App\PicDocument::where('pic_id', $pic_id)->where('id', $doc_id)->firstOrFail();
        $picDoc->delete();
        
        return redirect()->route('admin.list-pic')->with('success', 'Document removed from PIC successfully.');
    }

    public function editPicDocument($pic_id, $doc_id)
    {
        // Not implemented yet, just returning back to avoid crash
        return redirect()->route('admin.list-pic')->with('error', 'Fitur edit belum diimplementasikan.');
    }
}