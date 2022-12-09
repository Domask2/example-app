<?php

namespace App\Http\Controllers;

use App\Http\Requests\DataSourceAccessRequest;
use App\Models\DataSourceAccess;
use App\Repositories\DataSourceRepository;
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DataSourceAccessRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DataSourceAccessRequest $request)
    {
        $data = $request->validated();
        $dsa = DataSourceAccess::create($data);

        $dsr = new DataSourceRepository();
        $ds = $dsr->findBy('key', $dsa->key);
        return redirect()->route('ds.show', $ds->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $dataSourceAccess = DataSourceAccess::find($id);
        $ds_id = $dataSourceAccess->data_source_id;

        $this->authorize('delete', $dataSourceAccess);
        $dataSourceAccess->delete();
        return redirect(route('ds.show', $ds_id));
    }
}
