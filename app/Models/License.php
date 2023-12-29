<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//for log purpose
use App\Traits\LogsChanges;

class License extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'license_id';
    protected $fillable = ['license_name', 'license_desc'];
    protected $dates = ['deleted_at'];

    //for log purpose
    use LogsChanges;

    public function groupLicenses()
    {
        return $this->hasMany(GroupLicense::class, 'group_id', 'group_id');
    }


}
