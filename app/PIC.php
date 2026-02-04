<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PIC extends Model
{
    //timestamps
    public $timestamps = false;
    protected $table = 'QA_KKVListPic';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

}
