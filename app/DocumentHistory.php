<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\DocumentEquipment;
use App\User;

class DocumentHistory extends Model
{

    protected $table = 'QA_KKVDocumentHistory';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    /**
     * Get the document that owns the history
     */
    public function document()
    {
        return $this->belongsTo(DocumentEquipment::class, 'document_id');
    }

    /**
     * Get the user who made the update
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}