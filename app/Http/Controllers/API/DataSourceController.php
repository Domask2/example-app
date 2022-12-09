<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DataSourceCreateRequest;
use App\Http\Requests\DataSourceUpdateRequest;
use App\Models\DataSource;

class DataSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $ds = DataSource::with('dataSourceFields')->get();
        return response()->json($ds, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DataSourceCreateRequest $request)
    {
        $ds = DataSource::create($request->validated());
        return response()->json($ds, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $ds = DataSource::with('dataSourceFields')->find($id);
        return response()->json($ds, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DataSourceUpdateRequest $request, $id)
    {
        $ds = DataSource::find($id);
        $ds->update($request->validated());
        return response()->json($ds, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        DataSource::find($id)->delete();
        return response()->json('Deletion was successful', 200);
    }
}
