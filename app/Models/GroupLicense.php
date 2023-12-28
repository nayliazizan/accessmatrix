<?php
// app/Models/GroupLicense.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\LogsChanges;

class GroupLicense extends Model
{
    use SoftDeletes;
    use LogsChanges;

    protected $table = 'group_license';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function license()
    {
        return $this->belongsTo(License::class, 'license_id', 'license_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'group_id');
    }
}
