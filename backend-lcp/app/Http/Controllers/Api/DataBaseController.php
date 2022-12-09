<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DataBaseCreateRequest;
use App\Http\Resources\Api\ProjectResource;
use App\Http\Resources\DataBaseResource;
use App\Models\DataBase;
use App\Repositories\ProjectRepository;
use Illuminate\Http\JsonResponse;

class DataBaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(ProjectRepository $repository)
    {
        return response()->json([
            'db' => DataBaseResource::collection(DataBase::orderBy('key')->get()),
            'projectAll' => ProjectResource::collection($repository->getAllProjects())
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DataBaseCreateRequest $request
     * @return JsonResponse
     */
    public function store(DataBaseCreateRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $db = DataBase::create($data);
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
