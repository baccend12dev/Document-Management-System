<?php
namespace App;

use Illuminate\Database\Eloquent\Model;



class ModelQualificationMaster extends Model
{
    protected $table = 'QA_KKVSystemTools'; // Specify your table name here

    // If your table does not use 'id' as primary key, specify it:
    // protected $primaryKey = 'your_primary_key_column';

    // If your table does not use timestamps, disable them:
    public $timestamps = false;

    // If you want to allow mass assignment for certain columns:
        protected $guarded = ['id'];
    // protected $fillable = ['column1', 'column2', ...];
}