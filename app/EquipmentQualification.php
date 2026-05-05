<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DocumentEquipment;
use Illuminate\Support\Facades\DB;
use App\Traits\AuditTrail;
use App\AhuRoom;


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
    public function roomMaster()
    {
        return $this->hasMany(AhuRoom::class, 'service_area', 'serviceArea' );
    }

// === Tambahkan audit trail langsung di model ===
    use AuditTrail;
    
}
