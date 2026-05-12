<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PicDocument extends Model
{
    protected $table = 'QA_KKVpic_document';
    
    // Disable timestamps since they are not in the database table schema
    public $timestamps = false; 

    protected $fillable = [
        'pic_id',
        'document_id',
        'ccpic_id',
    ];

    public function pic()
    {
        return $this->belongsTo(PIC::class, 'pic_id');
    }

    public function ccPic()
    {
        return $this->belongsTo(PIC::class, 'ccpic_id');
    }

    public function document()
    {
        return $this->belongsTo(DocumentEquipment::class, 'document_id');
    }
}
