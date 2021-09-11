<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "Categories";
    protected $primaryKey = "token";
    protected $keyType = 'string';
    protected $fillable = ["token", "name"];
    public $timestamps = false;
    use HasFactory;
}
