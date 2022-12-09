<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DataSourceAccessRequest;
use App\Models\DataBase;
use App\Models\DataSource;
use App\Services\DataSourceAccessService;
use Illuminate\Http\Request;

class DataSourceAccessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DataSourceAccessRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, DataSourceAccessService $dataSourceAccessService)
    {
        $db = DataBase::where('key', $request->dataBaseKey)->first();

        if ($db) {
            $ds = DataSource::where('data_base_id', $db->id)->where('key', $request->dataSourceKey)->first();
            if ($ds) {
                $dataSourceAccessService->create($request, $ds);
                return response()->json('DataSourceAccess создан', 200);
            } else {
                return response()->json('DataSource не найден', 404);
            }
        } else {
            return response()->json('DataBase не найден', 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {

    }
}
