<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param  String $websiteToken
     * @return \Illuminate\Http\Response
     */
    public function getByWebSite(Request $request, String $webSiteToken)
    {
        $validator = Validator::make(["identifiant du site web" => $webSiteToken], ["identifiant du site web" => "exists:Articles,webSiteToken"]);
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
            $requestData = $request->all();
            (isset($requestData["nbr"])) ? $requestData["nbr"] = (int)($requestData["nbr"]) : $requestData["nbr"] = 15;
            (isset($requestData["page"])) ? $requestData["page"] = (int)($requestData["page"]) : $requestData["page"] = 1;

            $articleArray = (Article::where("webSiteToken", "=", $webSiteToken)->forPage($requestData["page"], $requestData["nbr"])->get())->toArray();
            return response()->json(
                [
                    "status" => 1,
                    "articles" => $articleArray
                ],
                200,
                [],
                JSON_UNESCAPED_UNICODE
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param  String $categoryToken
     * @return \Illuminate\Http\Response
     */
    public function getByCategory(Request $request, String $categoryToken)
    {
        $validator = Validator::make(["identifiant de la catégorie" => $categoryToken], ["identifiant de la catégorie" => "exists:Articles,categorieToken"]);
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
            $requestData = $request->all();
            (isset($requestData["nbr"])) ? $requestData["nbr"] = (int)($requestData["nbr"]) : $requestData["nbr"] = 15;
            (isset($requestData["page"])) ? $requestData["page"] = (int)($requestData["page"]) : $requestData["page"] = 1;

            $articleArray = (Article::where("categorieToken", "=", $categoryToken)->forPage($requestData["page"], $requestData["nbr"])->get())->toArray();

            return response()->json(
                [
                    "status" => 1,
                    "articles" => $articleArray
                ],
                200,
                [],
                JSON_UNESCAPED_UNICODE
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $requestData = $request->all();
        (isset($requestData["nbr"])) ? $requestData["nbr"] = (int)($requestData["nbr"]) : $requestData["nbr"] = 15;
        (isset($requestData["page"])) ? $requestData["page"] = (int)($requestData["page"]) : $requestData["page"] = 1;

        $dataDB = (Article::forPage($requestData["page"], $requestData["nbr"])->get())->toArray();
        if ($dataDB == []) {
            return response()->json(
                [
                    "status" => 0,
                    "errors" => ["db" => "Aucun article."]
                ],
                404,
                [],
                JSON_UNESCAPED_UNICODE
            );
        } else {

            return response()->json(
                [
                    "status" => 1,
                    "articles" => $dataDB
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  String  $token
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, String $token)
    {
        $requestData = $request->all();
        (isset($requestData["nbrNewView"])) ? $requestData["nbrNewView"] = (int) $requestData["nbrNewView"] : $requestData["nbrNewView"] = 0;
        $validator = Validator::make(["identifiant de l'article" => $token], ["identifiant de l'article" => "exists:Articles,token"]);
        if ($validator->fails()) {
            return response()->json(
                [
                    "status" => 0,
                    "errors" => $validator->errors()->toArray()
                ],
                404,
                [],
                JSON_UNESCAPED_UNICODE
            );
        } else {
            $article = Article::find($token);
            $article["nbrView"] = $article["nbrView"] + $requestData["nbrNewView"];
            $article->update();
            return response()->json(
                [
                    "status" => 1,
                    "article" => $article
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
     * @param  String  $token
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, String $token)
    {
        $article = Article::find($token);
        if ($article) {
            $requestData = $request->all();
            $validator = Validator::make($requestData, ["token" => "unique:Articles|min:10", "title" => "min:2|unique:Articles", "pageLink" => "url|unique:Articles", "imageLink" => "url", "contentBase" => "min:10", "date" => "date", "categorieToken" => "exists:Categories,token", "webSiteToken" => "exists:WebSites,token", "nbrView" => "numeric"]);
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
                if ($article->update($requestData)) {
                    foreach ($requestData as $key => $value) {
                        $article[$key] = $value;
                    }
                    return response()->json(
                        [
                            "status" => 1,
                            "article" => $article
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
                        406,
                        [],
                        JSON_UNESCAPED_UNICODE
                    );
                }
            }
        } else {
            return response()->json(
                [
                    "status" => 0,
                    "errors" => ["db" => "L'article sélectionné n'existe pas."]
                ],
                404,
                [],
                JSON_UNESCAPED_UNICODE
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  String  $token
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $token)
    {
        $validator = Validator::make(["identifiant de l'article" => $token], ["identifiant de l'article" => "exists:Articles,token"]);
        if ($validator->fails()) {
            return response()->json(
                [
                    "status" => 0,
                    "errors" => $validator->errors()->toArray()
                ],
                404,
                [],
                JSON_UNESCAPED_UNICODE
            );
        } else {
            Article::destroy($token);
            return response()->json(
                [
                    "status" => 1,
                ],
                200,
                [],
                JSON_UNESCAPED_UNICODE
            );
        }
    }

    /**
     * Search a article
     *
     * @param  String  $token
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $requestData = $request->all();
        if (isset($requestData["str"])) {


            (isset($requestData["nbr"])) ? $requestData["nbr"] = (int)($requestData["nbr"]) : $requestData["nbr"] = 15;
            (isset($requestData["page"])) ? $requestData["page"] = (int)($requestData["page"]) : $requestData["page"] = 1;

            $articleArray = (Article::where("title", "like", "%" . $requestData["str"] . "%")->orwhere("contentBase", "like", "%" . $requestData["str"] . "%")->forPage($requestData["page"], $requestData["nbr"])->get())->toArray();
            if ($articleArray == []) {
                return response()->json(
                    [
                        "status" => 0,
                        "errors" => ["db" => "Aucun résultat."]
                    ],
                    404,
                    [],
                    JSON_UNESCAPED_UNICODE
                );
            } else {
                return response()->json(
                    [
                        "status" => 1,
                        "articles" => $articleArray
                    ],
                    200,
                    [],
                    JSON_UNESCAPED_UNICODE
                );
            }
        } else {
            return response()->json(
                [
                    "status" => 0,
                    "errors" => ["str" => "L'attribut 'str' est manquant."]
                ],
                406,
                [],
                JSON_UNESCAPED_UNICODE
            );
        }
    }
}
