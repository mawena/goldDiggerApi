<?php

namespace App\Http\Controllers;

use App\Models\Article;
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
    public function getByWebSite(String $webSiteToken)
    {
        $validator = Validator::make(["identifiant du site web" => $webSiteToken], ["identifiant du site web" => "required|exists:Articles,webSiteToken"]);
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
            $dataDB = Article::all();
            $articleArray = [];
            foreach ($dataDB as $article) {
                if ($article["webSiteToken"] == $webSiteToken) {
                    $articleArray[] = $article;
                }
            }
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
    public function getByCategory(String $categoryToken)
    {
        $validator = Validator::make(["identifiant de la catégorie" => $categoryToken], ["identifiant de la catégorie" => "required|exists:Articles,categorieToken"]);
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
            $dataDB = Article::all();
            $articleArray = [];
            foreach ($dataDB as $article) {
                if ($article["categorieToken"] == $categoryToken) {
                    $articleArray[] = $article;
                }
            }
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
    public function index()
    {
        $dataDB = Article::all();
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
    public function show(String $token)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  String  $token
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $token)
    {
        //
    }
}
