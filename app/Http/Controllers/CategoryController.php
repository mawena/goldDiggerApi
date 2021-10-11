<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataDB = Category::all();
        if ($dataDB == []) {
            return response()->json(
                [
                    'status' => 0,
                    "errors" => ["Aucune categorie."]
                ],
                404,
                [],
                JSON_UNESCAPED_UNICODE
            );
        } else {
            return response()->json(
                [
                    "status" => 1,
                    "catogories" => $dataDB
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
        $validator = Validator::make($requestData, [
            'name' => 'required|unique:Categories|min:2',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 0,
                    'errors' => $validator->errors()->toArray()
                ],
                400,
                [],
                JSON_UNESCAPED_UNICODE
            );
        } else {
            $requestData["token"] = sha1(date("d M Y H i s") . $requestData["name"]);
            if (category::create($requestData)) {
                return response()->json(
                    [
                        "status" => 1,
                        "category" => [
                            "token" => $requestData["token"],
                            "name" => $requestData["name"]
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
                        "errors" => ["db" => "Erreur durant l'ajout de la catégorie."]
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
     * @param  String  $token
     * @return \Illuminate\Http\Response
     */
    public function show(String $token)
    {
        $dataDB = Category::find($token);
        if ($dataDB) {
            return response()->json(
                [
                    "status" => 1,
                    "catogory" => $dataDB
                ],
                200,
                [],
                JSON_UNESCAPED_UNICODE
            );
        } else {
            return response()->json(
                [
                    'status' => 0,
                    "errors" => ["db" => "La catégorie sélectionné n'existe pas."]
                ],
                404,
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
        $categoryData = Category::find($token);
        $requestData = $request->all();
        if ($categoryData) {
            $validator = Validator::make(["name" => $requestData["name"]], ["name" => "required|unique:Categories|min:2"]);
            if ($validator->fails()) {
                return response()->json(
                    [
                        'status' => 0,
                        "errors" => $validator->errors()->toArray()
                    ],
                    409,
                    [],
                    JSON_UNESCAPED_UNICODE
                );
            } else {
                $categoryData["name"] = $requestData["name"];
                if ($categoryData->update()) {
                    return [
                        "status" => 1
                    ];
                } else {
                    return response()->json(
                        [
                            'status' => 0,
                            "errors" => ["db" => "Erreur durant la mise à jour de la catégorie."]
                        ],
                        500,
                        [],
                        JSON_UNESCAPED_UNICODE
                    );
                }
            }
        } else {
            return response()->json(
                [
                    'status' => 0,
                    "errors" => ["db" => "La catégorie sélectionné n'existe pas."]
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
     * @param  String $token
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $token)
    {
        if ((Validator::make(["token" => $token], ["token" => "exists:Categories"]))->fails()) {
            return response()->json(
                [
                    "status" => 0,
                    "errors" => ["db" => "La catégorie sélectionné n'existe pas."]
                ],
                404,
                [],
                JSON_UNESCAPED_UNICODE
            );
        } else {
            Category::destroy($token);
            return [
                "status" => 1
            ];
        }
    }
}
