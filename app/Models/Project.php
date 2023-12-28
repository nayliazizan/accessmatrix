<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//for log purpose
use App\Traits\LogsChanges;

class Project extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'project_id';
    protected $fillable = ['project_name', 'project_desc'];
    protected $dates = ['deleted_at'];

    //for log purpose
    use LogsChanges;

    public function groupProjects()
    {
        return $this->hasMany(GroupProject::class, 'group_id', 'group_id');
    }
}
