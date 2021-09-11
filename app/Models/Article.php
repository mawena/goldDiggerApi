<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $table = "Articles";
    protected $primaryKey = "token";
    protected $keyType = 'string';
    protected $fillable = ['title', 'pageLink', 'imageLink', 'contentBase', 'date', 'categorieToken', 'webSiteToken'];
    public $timestamps = false;
}
