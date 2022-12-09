<?php


namespace App\Http\Controllers;

use App\Http\Requests\AdminAddTableRequest;
use App\Http\Requests\DataSourceCreateRequest;
use App\Models\DataSource;
use App\Repositories\DataSourceRepository;
use App\Services\DataSourceService;
use App\Services\Magic\MagicService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class DataSourceController extends Controller
{
    private $repository;

    public function __construct(MagicService $service, DataSourceRepository $repository)
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdminAddTableRequest $request
     * @param DataSourceService $dataSourceService
     * @return Application|RedirectResponse|Redirector
     */
    public function store(AdminAddTableRequest $request, DataSourceService $dataSourceService)
    {
        $validated_data = $request->validated();
        $dataSourceService->create($validated_data);

        return redirect(route('db.show', $validated_data['data_base_id']));
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
        $dataSource = $this->repository->find($id);
        $this->authorize('view', $dataSource);

        $fields = [];
        $definition = [];
        $description = '';
        switch ($dataSource->type) {
            case "BASE TABLE":
                $fields = $this->magicService->getFields($dataSource);
                break;
            case "VIEW":
                $definition = $this->magicService->getTableViewDefinition($dataSource);
                $definition->definition = $definition->view_definition;
                $fields = $this->magicService->getFields($dataSource);
                break;
            case "PROCEDURE":
            case "FUNCTION":
                $definition = $this->magicService->getRoutineDefinition($dataSource);
                $fields = $this->magicService->getRoutineParams($dataSource);

                /**
                 * Получим часть declare
                 * И передадим ее как description
                 */
                $dfn = explode('declare', $definition);
                $str = $dfn[1] ?? false;
                $vars = $str ? explode('begin', $str)[0] : false;
                $arr_vars = $vars ? explode(';', $vars) : [];

                $arr_vars2 = [];
                foreach ($arr_vars as $var) {
                    $v = explode('=', $var)[0];
                    $str = trim(str_replace('\r\n', '', $v));
                    $str = trim(str_replace('\n', '', $str));

                    if ($str !== '' && substr($str, 0, 2) === '__') {
                        $arr_old = explode(' ', $str);
                        $arr_vars2[] = [
                            'name' => substr($arr_old[0], 2),
                            'type' => $arr_old[1],
                        ];
                    }
                }

                $description = "json:" . json_encode([
                    'vars' => $arr_vars2,
                ]);
                break;
        }

        return view('ds.show', compact(['dataSource', 'fields', 'definition', 'description']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DataSource $dataSource
     * @return void
     */
    public function edit(DataSource $dataSource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DataSourceCreateRequest $request
     * @param $id
     * @return Application|RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function update(DataSourceCreateRequest $request, $id)
    {
        $dataSource = $this->repository->find($id);
        $this->authorize('view', $dataSource);
        $dataSource->update($request->validated());

        return redirect(route('ds.show', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Application|RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function destroy($id)
    {
        $dataSource = $this->repository->find($id);
        $this->authorize('view', $dataSource);
        $dataBase = $dataSource->dataBase;
        $dataSource->delete();

        return redirect(route('db.show', $dataBase));
    }
}
