<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupLicenseLog extends Model
{
    use HasFactory;
    protected $table = 'group_license_logs';

    protected $fillable = ['user_id', 'group_id', 'license_id', 'action_type'];

    public function license()
    {
        return $this->belongsTo(License::class);
    }
}
