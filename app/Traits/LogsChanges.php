<?php

// app/Traits/LogsChanges.php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Log;

trait LogsChanges
{
    public static function bootLogsChanges()
    {
        static::updating(function ($model) {
            self::logChange('update', $model);
        });

        static::creating(function ($model) {
            self::logChange('create', $model);
        });

        static::deleting(function ($model) {
            self::logChange('delete', $model);
        });

        // Check if the model uses the SoftDeletes trait before registering the event
        if (in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses_recursive(get_called_class()))) {
            static::restoring(function ($model) {
                self::logChange('restore', $model);
            });
        }
    }

    public static function getLogData($action, $model)
    {
        $data = [
            'type_action' => $action,
            'user_id' => auth()->id(),
            'table_name' => $model->getTable(),
            'record_id' => $model->getKey(),
            'record_name' => self::getRecordName($model),
            'old_value' => null,
            'new_value' => null,
        ];
        
        if ($action === 'update') {
            $original = $model->getOriginal();
        
            // Get only the columns that were actually changed
            $changedColumns = array_filter($model->getDirty(), function ($value, $key) use ($original) {
                return $original[$key] != $value;
            }, ARRAY_FILTER_USE_BOTH);
        
            if (!empty($changedColumns)) {
                $data['column_name'] = implode(', ', array_keys($changedColumns));
        
                // Save the original values in old_value
                $data['old_value'] = json_encode(array_intersect_key($original, $changedColumns));
        
                // Save the changed values in new_value
                $data['new_value'] = json_encode(array_intersect_key($model->getAttributes(), $changedColumns));
            }
        } elseif ($action === 'create') {
            // Capture all model attributes as the new value for creates
            $data['new_value'] = json_encode($model->getAttributes());
        } else {
            // For other actions, set the column_name to null
            $data['column_name'] = null;
        }
        
        return $data;
        
    }

    protected static function getRecordName($model)
    {
        switch ($model->getTable()) {
            case 'staffs':
                return $model->staff_id_rw;
            case 'licenses':
                return $model->license_name;
            case 'projects':
                return $model->project_name;
            case 'groups':
                return $model->group_name;
            default:
                return ''; 
        }
    }

    protected static function getUpdatedColumnName($model)
    {
        return implode(', ', array_keys($model->getChanges()));
    }

    public static function logChange($action, $model)
    {
        $logData = self::getLogData($action, $model);

        // Create a log entry
        Log::create($logData);
    }
       
}