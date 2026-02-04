<?php

namespace App\Exports;

class DocumentsExport
{
    /**
     * Transform the collection of documents into an array for export.
     *
     * @param  \Illuminate\Support\Collection  $documents
     * @return array
     */
    public static function transform($documents)
    {
        $data = [];

        // Add Headings
        $data[] = [
            // Document Headers
            'Doc Number',
            'Doc Sub Menu',
            'Document Type',
            'Revision Number',
            'Requalification',
            'Model Type',
            'Approved Date',
            'Review Frequency',
            'Next Review',
            'Remarks',

            // Equipment Headers
            'Equipment ID',
            'Product Code',
            'Equipment Name',
            'Product Name',
            'No Batch',
            'Active Substance',
            'System Name',
            'Department',
            'Building',
            'Room Name',
            'Room Number',
            'Location',
            'Service Area',
            'AHU',
            'Type',
            'Model',
        ];

        foreach ($documents as $doc) {
            $data[] = [
                // Document Data
                $doc->doc_number,
                $doc->sub_menu,
                $doc->document_type,
                $doc->revision_number,
                $doc->requalification,
                $doc->modelType,
                $doc->approved_date,
                $doc->review_frequency,
                $doc->next_review,
                $doc->remarks,

                // Equipment Data
                isset($doc->equipment->equipment_id) ? $doc->equipment->equipment_id : '',
                isset($doc->equipment->product_code) ? $doc->equipment->product_code : '',
                isset($doc->equipment->equipment_name) ? $doc->equipment->equipment_name : '',
                isset($doc->equipment->product_name) ? $doc->equipment->product_name : '',
                isset($doc->equipment->no_batch) ? $doc->equipment->no_batch : '',
                isset($doc->equipment->active_subtance) ? $doc->equipment->active_subtance : '',
                isset($doc->equipment->systemName) ? $doc->equipment->systemName : '',
                isset($doc->equipment->department) ? $doc->equipment->department : '',
                isset($doc->equipment->building) ? $doc->equipment->building : '',
                isset($doc->equipment->roomName) ? $doc->equipment->roomName : '',
                isset($doc->equipment->roomNumber) ? $doc->equipment->roomNumber : '',
                isset($doc->equipment->location) ? $doc->equipment->location : '',
                isset($doc->equipment->serviceArea) ? $doc->equipment->serviceArea : '',
                isset($doc->equipment->ahu) ? $doc->equipment->ahu : '',
                isset($doc->equipment->type) ? $doc->equipment->type : '',
                isset($doc->equipment->model) ? $doc->equipment->model : '',
            ];
        }

        return $data;
    }
}
