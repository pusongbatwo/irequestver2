<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentLogo extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_name',
        'logo_path',
    ];
}
