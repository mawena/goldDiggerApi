<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = "Articles";
    protected $primaryKey = "token";
    protected $keyType = 'string';
    protected $fillable = ['token', 'title', 'pageLink', 'imageLink', 'contentBase', 'date', 'categorieToken', 'webSiteToken', 'nbrView'];
    public $timestamps = false;
    use HasFactory;
}
