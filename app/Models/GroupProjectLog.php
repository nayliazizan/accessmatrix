<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupProjectLog extends Model
{
    use HasFactory;
    protected $table = 'group_project_logs';

    protected $fillable = ['user_id', 'group_id', 'project_id', 'action_type'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
