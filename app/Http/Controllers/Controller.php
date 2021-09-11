<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}

/**
 * Create a slug with a chain
 *
 * @param  String  $subject
 * @param  Array  $searchArray
 * @param  String  $replace
 * @return String
 */
function slugger(String $subject, array $searchArray = [" "], String $replace = "_")
{
    foreach ($searchArray as $search) {
        $subject = str_replace($search, $replace, $subject);
    }
    return $subject;
}
