<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DataSourceFieldUpdateRequest;
use App\Models\DataBase;
use App\Models\DataSource;
use App\Models\DataSourceField;
use App\Services\DataSourceFieldService;
use Illuminate\Http\Request;

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, DataSourceFieldService $dataSourceFieldService)
    {
        $db = DataBase::where('key', $request->db)->first();
        if ($db) {
            $ds = DataSource::where('key', $request->ds)->where("data_base_id", $db->id)->first();
            if ($ds) {
                $result = $dataSourceFieldService->createDsfRemote($request->dsf, $ds);
                return response()->json($result, 200);
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
     * @param \Illuminate\Http\Request $request
     * @param int $id
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
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        DataSourceField::find($id)->delete();
        return response()->json('Deletion was successful', 200);
    }
}
