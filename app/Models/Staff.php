<?php
// app/Models/Staff.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//for log purpose
use App\Traits\LogsChanges;

class Staff extends Model
{
    use HasFactory;
    protected $table = 'staffs';
    protected $primaryKey = 'staff_id';
    protected $fillable = ['group_id', 'staff_id_rw', 'staff_name', 'dept_id', 'dept_name', 'status'];

    //for log purpose
    use LogsChanges;

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'group_id');
    }

    
}
