<?php


namespace App\Http\Controllers;

use App\Http\Requests\DataSourceFieldCreateRequest;
use App\Http\Requests\DataSourceFieldUpdateRequest;
use App\Models\DataSourceField;
use App\Repositories\DataSourceFieldRepository;
use App\Repositories\DataSourceRepository;
use App\Services\DataSourceFieldService;
use App\Services\Magic\MagicService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class DataSourceFieldController extends Controller
{
    private $repository;

    public function __construct(MagicService $service, DataSourceFieldRepository $repository)
    {
        parent::__construct($service);
        $this->repository = $repository;
    }

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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DataSourceFieldCreateRequest $request
     * @param DataSourceRepository $dataSourceRepository
     * @param DataSourceFieldService $dataSourceFieldService
     * @return Application|RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function store(DataSourceFieldCreateRequest $request,
                          DataSourceRepository $dataSourceRepository,
                          DataSourceFieldService $dataSourceFieldService)
    {
        $validated_data = $request->validated();

        $dataSource = $dataSourceRepository->find($validated_data['data_source_id']);
        $this->authorize('view', $dataSource);

        $dataSourceFieldService->create($dataSource, $validated_data);
        return redirect(route('ds.show', $validated_data['data_source_id']));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\DataSourceField $dataSourceField
     * @return \Illuminate\Http\Response
     */
    public function show(DataSourceField $dataSourceField)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\DataSourceField $dataSourceField
     * @return \Illuminate\Http\Response
     */
    public function edit(DataSourceField $dataSourceField)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DataSourceFieldUpdateRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(DataSourceFieldUpdateRequest $request,
                           $id)
    {
        $dataSourceField = $this->repository->find($id);
        $dataSourceField->update($request->validated());

        return redirect()->route('ds.show', $dataSourceField->dataSource);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DataSourceFieldRepository $dataSourceFieldRepository
     * @param $id
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(DataSourceFieldRepository $dataSourceFieldRepository, $id)
    {
        $dataSourceField = $this->repository->find($id);
        $dataSource = $dataSourceField->dataSource;
        $dataSourceField->delete();
        return redirect(route('ds.show', $dataSource));
    }
}
