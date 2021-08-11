<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebSite extends Model
{
    protected $table = "WebSites";
    protected $primaryKey = "token";
    protected $fillable = ["token", "name", "slug", "indexPageLink"];
    public $timestamps = false;
    use HasFactory;
}
