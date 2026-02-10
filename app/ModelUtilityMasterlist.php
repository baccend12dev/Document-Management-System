<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}

