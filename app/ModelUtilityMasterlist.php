<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrail;

class ModelUtilityMasterlist extends Model {
  protected $table = 'QA_KKVMasterUtility';
  public $timestamps = false;

  protected $fillable = [
    'subject',
    'system',
    'model',
    'building',
    'location',
    'servicearea',
    'roomNumber',
    'roomName',
    'encrypt',
  ];

  public function utilityDocuments()
  {
    return $this->hasMany(DocumentEquipment::class, 'tools_id', 'id')->where('sub_menu', 'utility');
  }
  use AuditTrail;

}

