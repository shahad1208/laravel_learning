<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $table = 'todo';
    protected $dates = ['deleted_at'];
    protected $fillable = ['title', 'description', 'due_date', 'status'];
}
