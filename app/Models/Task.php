<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Task as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Task extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = ['title', 'description', 'status', 'due_date'];
}
