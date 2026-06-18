<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PIC extends Model
{
    //timestamps
    public $timestamps = false;
    protected $table = 'QA_KKVListPic';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function picDocuments()
    {
        return $this->hasMany(PicDocument::class, 'pic_id');
    }

    public function ccPicDocuments()
    {
        return $this->hasMany(PicDocument::class, 'ccpic_id');
    }

    public function getAllDocuments()
    {
        $mainAssignments = $this->picDocuments->groupBy('document_id');
        $documentsList = [];

        foreach ($mainAssignments as $docId => $rows) {
            $firstRow = $rows->first();
            if (!$firstRow || !$firstRow->document) continue;

            $ccNames = [];
            foreach ($rows as $row) {
                if ($row->ccPic) {
                    $ccNames[] = $row->ccPic->name;
                }
            }

            $documentsList[] = [
                'id' => $firstRow->id,
                'doc_number' => $firstRow->document->doc_number,
                'document_type' => $firstRow->document->document_type,
                'next_review' => $firstRow->document->next_review,
                'sub_menu' => $firstRow->document->sub_menu,
                'role' => 'Main PIC',
                'cc_list' => empty($ccNames) ? '-' : implode(', ', $ccNames),
                'is_main' => true,
            ];
        }

        $ccAssignments = $this->ccPicDocuments;

        foreach ($ccAssignments as $row) {
            if (!$row->document) continue;

            // Fetch all CC names for this document from the main PIC's rows
            $allRowsForDoc = PicDocument::with('ccPic')
                ->where('pic_id', $row->pic_id)
                ->where('document_id', $row->document_id)
                ->get();
            
            $ccNames = [];
            foreach ($allRowsForDoc as $r) {
                if ($r->ccPic) {
                    $ccNames[] = $r->ccPic->name;
                }
            }

            $documentsList[] = [
                'id' => $row->id,
                'doc_number' => $row->document->doc_number,
                'document_type' => $row->document->document_type,
                'next_review' => $row->document->next_review,
                'sub_menu' => $row->document->sub_menu,
                'role' => 'CC PIC',
                'cc_list' => empty($ccNames) ? '-' : implode(', ', $ccNames),
                'is_main' => false,
                'main_pic_name' => $row->pic ? $row->pic->name : 'N/A',
            ];
        }

        return $documentsList;
    }
}
