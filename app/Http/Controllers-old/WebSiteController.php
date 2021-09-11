<?php

namespace App\Http\Controllers;

use App\Models\WebSite;
use Illuminate\Http\Request;

class WebSiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return WebSite::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        WebSite::create($request->all());
        return [
            "status" => "success"
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WebSite  $webSite
     * @return \Illuminate\Http\Response
     */
    public function show(WebSite $webSite)
    {
        return $webSite;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WebSite  $webSite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WebSite $webSite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WebSite  $webSite
     * @return \Illuminate\Http\Response
     */
    public function destroy(WebSite $webSite)
    {
        return [
            "status" => $webSite
        ];
    }
}
