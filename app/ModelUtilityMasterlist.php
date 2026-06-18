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

  public function documents()
  {
    return $this->hasMany(DocumentEquipment::class, 'tools_id', 'id')->where('sub_menu', 'utility');
  }

  public function getEquipmentIdAttribute()
  {
    return $this->system;
  }

  public function getProductCodeAttribute()
  {
    return $this->model;
  }

  public function getEquipmentNameAttribute()
  {
    return $this->subject;
  }

  public function getDepartmentAttribute()
  {
    return $this->servicearea;
  }

  public function getDosageCodeAttribute()
  {
    return $this->location;
  }

  public function getSubMenuAttribute()
  {
    return 'utility';
  }

  use AuditTrail;
}

