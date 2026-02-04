<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

trait AuditTrail
{
    protected static function bootAuditTrail()
    {
        // INSERT
        static::created(function ($model) {
            self::logAudit($model, 'created', [], $model->getAttributes());
        });

        // UPDATE
        static::updated(function ($model) {
            $dirty = $model->getDirty();
            
            if (empty($dirty)) {
                return;
            }
            
            // DAPATKAN SEMUA DATA ORIGINAL (OLD VALUES)
            $oldValues = $model->getOriginal();
            
            // HANYA FIELD YANG BERUBAH SAJA (NEW VALUES)
            $newValues = $dirty;
            
            self::logAudit($model, 'updated', $oldValues, $newValues);
        });

        // DELETE
        static::deleted(function ($model) {
            self::logAudit($model, 'deleted', $model->getOriginal(), []);
        });
    }

    protected static function logAudit($model, $action, $oldValues, $newValues)
    {
        DB::table('QA_KKVaudit_trails')->insert([
            'user_id'    => auth()->check() ? auth()->id() : null,
            'table_name' => $model->getTable(),
            'record_id'  => $model->getKey(),
            'action'     => strtoupper($action),
            'old_values' => json_encode($oldValues, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'new_values' => json_encode($newValues, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'created_at' => Carbon::now(),
        ]);
    }
}