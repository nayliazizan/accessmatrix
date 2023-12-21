<?php
// app/Models/Group.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'group_id';
    protected $fillable = ['group_name', 'group_desc'];

    public function licenses()
    {
        return $this->belongsToMany(License::class, 'group_license', 'group_id', 'license_id')->withTimestamps();
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'group_project', 'group_id', 'project_id')->withTimestamps();
    }

    public function groupProjects()
    {
        return $this->hasMany(GroupProject::class, 'group_id', 'group_id');
    }

    public function groupLicenses()
    {
        return $this->hasMany(GroupLicense::class, 'group_id', 'group_id');
    }

    public function staffs()
    {
        return $this->hasMany(Staff::class, 'group_id', 'group_id');
    }

}
