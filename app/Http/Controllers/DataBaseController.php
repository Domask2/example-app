<?php

namespace App\Http\Controllers;

use App\Http\Requests\DataBaseCreateRequest;
use App\Models\DataBase;
use App\Repositories\DataBaseRepository;
use App\Services\Magic\MagicService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class DataBaseController extends Controller
{
    private $repository;

    public function __construct(MagicService $service, DataBaseRepository $repository)
    {
        parent::__construct($service);
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //sdfg
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('db.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DataBaseCreateRequest $request
     * @return RedirectResponse
     */
    public function store(DataBaseCreateRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $db = DataBase::create($data);
        return redirect()->route('db.show', $db->id);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function show($id)
    {
        $dataBase = $this->repository->find($id);
        $this->authorize('view', $dataBase);
        try {
            $tables = $this->magicService->getTables($dataBase);
            $routines = $this->magicService->getRoutines($dataBase);

            return view('db.show', compact(['dataBase', 'tables', 'routines']));
        } catch (\Exception $e) {
            return view('db.err', compact(['dataBase']));
        }

        /**
         * Процедуры вытаскиваются. Пока не используется.
         * $procedures = $this->magicService->getProcedures($database);
         */

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DataBase $dataBase
     * @return void
     */
    public function edit(DataBase $dataBase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DataBaseCreateRequest $request
     * @param $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(DataBaseCreateRequest $request, $id)
    {
        /** @var DataBase $dataBase */
        $dataBase = $this->repository->find($id);
        $dataBase->update($request->validated());

        return redirect(route('db.show', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $dataBase = $this->repository->find($id);
        $dataBase->delete();
        return redirect()->route('db.index');
    }
}
