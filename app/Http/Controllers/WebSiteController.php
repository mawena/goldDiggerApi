<?php

namespace App\Http\Controllers;

use App\Models\WebSite;
use Illuminate\Support\Facades\Validator;
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
        $dataDB = WebSite::all();
        if ($dataDB == []) {
            return response()->json(
                [
                    "status" => 0,
                    "errors" => [
                        "db" => "Aucun site web."
                    ]
                ],
                404,
                [],
                JSON_UNESCAPED_UNICODE
            );
        } else {
            return response()->json(
                [
                    "status" => 1,
                    "websites" => $dataDB
                ],
                200,
                [],
                JSON_UNESCAPED_UNICODE
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, ["name" => "required|min:2|unique:WebSites", "indexPageLink" => "required|url|unique:WebSites"]);
        if ($validator->fails()) {
            return response()->json(
                [
                    "status" => 0,
                    "errors" => $validator->errors()->toArray()
                ],
                406,
                [],
                JSON_UNESCAPED_UNICODE
            );
        } else {
            $requestData["token"] = sha1(date("d M Y H i s") . $requestData["name"]);

            // Création du slug
            $requestData["slug"] = slugger($requestData["name"], [" ", "-", ".", "/", "\\"]);
            if (WebSite::create($requestData)) {
                return response()->json(
                    [
                        "status" => 1,
                        "website" => [
                            "token" => $requestData["token"],
                            "name" => $requestData["name"],
                            "slug" => $requestData["slug"],
                            "indexPageLink" => $requestData["indexPageLink"]
                        ]
                    ],
                    200,
                    [],
                    JSON_UNESCAPED_UNICODE
                );
            } else {
                return response()->json(
                    [
                        "status" => 0,
                        "errors" => ["db" => "Erreur durant l'ajout du site web."]
                    ],
                    500,
                    [],
                    JSON_UNESCAPED_UNICODE
                );
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  String $token
     * @return \Illuminate\Http\Response
     */
    public function show(String $token)
    {
        $dataDB = WebSite::find($token);
        if ($dataDB == []) {
            return response()->json(
                [
                    "status" => 0,
                    "errors" => ["db" => "Le site web sélectionné n'existe pas."]
                ],
                404,
                [],
                JSON_UNESCAPED_UNICODE
            );
        } else {
            return response()->json(
                [
                    "status" => 1,
                    "website" => $dataDB
                ],
                200,
                [],
                JSON_UNESCAPED_UNICODE
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  String $token
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, String $token)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, ["token" => "unique:WebSites", "name" => "min:2|unique:WebSites", "indexPageLink" => "url|unique:WebSites"]);
        if ($validator->fails()) {
            return response()->json(
                [
                    "status" => 0,
                    "errors" => $validator->errors()->toArray()
                ],
                406,
                [],
                JSON_UNESCAPED_UNICODE
            );
        } else {
            $website = WebSite::find($token);
            if ($website) {
                if ($website->update($requestData)) {
                    $requestData["slug"] = slugger($requestData["name"]);
                    foreach($requestData as $key => $value){
                        $website[$key] = $value;
                    }
                    return response()->json(
                        [
                            "status" => 1,
                            "website" => $website
                        ],
                        200,
                        [],
                        JSON_UNESCAPED_UNICODE
                    );
                } else {
                    return response()->json(
                        [
                            "status" => 0,
                            "errors" => ["db" => "Erreur durant la mise à jour."]
                        ],
                        500,
                        [],
                        JSON_UNESCAPED_UNICODE
                    );
                }
            } else {
                return response()->json(
                    [
                        "status" => 0,
                        "errors" => ["db" => "Le site web sélectionné n'existe pas."]
                    ],
                    404,
                    [],
                    JSON_UNESCAPED_UNICODE
                );
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  String $token
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $token)
    {
        if (Validator::make(["token" => $token], ["token" => "exists:WebSites"])->fails()) {
            return response()->json(
                [
                    "status" => 0,
                    "errors" => ["db" => "Le site web sélectionné n'existe pas."]
                ],
                404,
                [],
                JSON_UNESCAPED_UNICODE
            );
        } else {
            WebSite::destroy($token);
            return [
                "status" => 1,
            ];
        }
    }
}
