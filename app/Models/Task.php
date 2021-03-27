<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['dimension_id', 'name', 'active', 'created_at', 'updated_at'];
    use HasFactory;
}
