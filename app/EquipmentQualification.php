<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DocumentEquipment;
use Illuminate\Support\Facades\DB;
use App\Traits\AuditTrail;


class EquipmentQualification extends Model
{
    protected $table = 'QA_KKVequipment_qualifications';
    protected $primaryKey = 'id';
    //fillable quard
    protected $guarded = [];

    public function documents()
    {
        return $this->hasMany(DocumentEquipment::class, 'tools_id', 'id');
    }

// === Tambahkan audit trail langsung di model ===
    use AuditTrail;
    
}
