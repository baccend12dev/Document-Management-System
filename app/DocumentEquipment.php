<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EquipmentQualification;
use Illuminate\Support\Facades\DB;
use App\Traits\AuditTrail;

class DocumentEquipment extends Model
{
    protected $table = 'QA_KKVdocumentEquipment';
    protected $primaryKey = 'id';
    //fillable quard
    protected $guarded = [];

    public function equipment()
    {
        return $this->belongsTo(EquipmentQualification::class, 'tools_id');
    }

// === Tambahkan audit trail langsung di model ===
    use AuditTrail;
    
}
