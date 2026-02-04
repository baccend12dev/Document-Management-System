<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EquipmentQualification;
use Illuminate\Support\Facades\DB;
use App\Traits\AuditTrail;

class AhuRoom extends Model
{
    protected $table = 'QA_KKVahu_code';
    // use guard
    protected $guarded = [];
    // Relasi dengan EquipmentQualification
    public function equipmentQualification()
    {
        return $this->belongsTo(EquipmentQualification::class);
    }

    use AuditTrail;
}
