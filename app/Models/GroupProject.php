<?php
// app/Models/GroupProject.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupProject extends Model
{
    use SoftDeletes;

    protected $table = 'group_project';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'project_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'group_id');
    }
}
