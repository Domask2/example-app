<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DataSourceFieldCreateRequest;
use App\Http\Requests\DataSourceFieldUpdateRequest;
use App\Models\DataSourceField;

class DataSourceFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $dsf = DataSourceField::paginate(10);
        return response()->json($dsf, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DataSourceFieldCreateRequest $request)
    {
        $dsf = DataSourceField::create($request->validated());
        return response()->json($dsf, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $dsf = DataSourceField::find($id);
        return response()->json($dsf, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DataSourceFieldUpdateRequest $request, $id)
    {
        $dsf = DataSourceField::find($id);
        $dsf->update($request->validated());
        return response()->json($dsf, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        DataSourceField::find($id)->delete();
        return response()->json('Deletion was successful', 200);
    }
}
