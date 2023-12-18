<?php
// app/Models/GroupLicense.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupLicense extends Model
{
    use SoftDeletes;
    protected $table = 'group_license';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function license()
    {
        return $this->belongsTo(License::class, 'license_name', 'license_name');
    }
}
