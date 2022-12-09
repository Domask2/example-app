<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DataBaseCreateRequest;
use App\Http\Resources\DataBaseResource;
use App\Models\DataBase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DataBaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return DataBaseResource::collection(DataBase::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DataBaseCreateRequest $request
     * @return JsonResponse
     */
    public function store(DataBaseCreateRequest $request)
    {
        $db = DataBase::create($request->validated());
        return response()->json($db, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param DataBase $db
     * @return DataBaseResource
     */
    public function show(DataBase $db)
    {
        $this->authorize('view', $db);
        return new DataBaseResource($db);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DataBaseCreateRequest $request
     * @param DataBase $db
     * @return JsonResponse
     */
    public function update(DataBaseCreateRequest $request, DataBase $db)
    {
        $this->authorize('view', $db);
        $db->update($request->validated());
        return response()->json($db, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DataBase $db
     * @return JsonResponse
     */
    public function destroy(DataBase $db)
    {
        $this->authorize('view', $db);
        $db->delete();
        return response()->json('Deletion was successful', 200);
    }
}
