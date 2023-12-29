<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $primaryKey = 'log_id';

    protected $fillable = [
        'type_action',
        'user_id',
        'table_name',
        'column_name',
        'record_id',
        'old_value',
        'new_value',
    ];

    public $timestamps = true;

    protected $casts = [
        'old_value' => 'json',
        'new_value' => 'json',
    ];
}
