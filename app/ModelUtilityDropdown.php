<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelUtilityDropdown extends Model
{
    protected $table = 'QA_KKVUtilityDropdown';

    public $timestamps = false;

    protected $fillable = [
        'subject',
        'system',
        'model',
        'building',
        'location',
        'servicearea',
  ];
}
