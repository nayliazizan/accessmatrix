<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class License extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'license_id';
    protected $fillable = ['license_name', 'license_desc'];
    protected $dates = ['deleted_at'];

}
