<?php

namespace App\Http\Controllers\Magic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MagicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $db_key
     * @param $ds_key
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($db_key, $ds_key)
    {
        $data = $this->magicService->index($db_key, $ds_key);
        $response = '';

        switch (request()->__to) {
            case 'file':
                Storage::disk('local')->delete('test.txt');
                foreach ($data['data'] as $row) {
                    $row_export = [];
                    foreach ($row as $val) {
                        $row_export[] = $val;
                    }

                    Storage::disk('local')->append('test.txt', implode(request()->__sep, $row_export));
                }

                if (!Storage::exists('test.txt'))
                    Storage::disk('local')->put('test.txt', 'Нет данных');

                $response = Storage::download('test.txt');
                break;

            case 'json':
            default:
                $response = response()->json([
                    'data' => $data,
                    'user_id' => is_null(auth()->user()) ? -1 : auth()->user()->id
                ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $ds_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $db_key, $ds_key)
    {
        $ret = [];
        switch (request()->__method) {
            case 'store':
                $ret = $this->magicService->store($db_key, $ds_key);
                break;
            case 'update':
                $ret = $this->magicService->update($db_key, $ds_key);
                break;
            case 'destroy':
                $ret = $this->magicService->destroy($db_key, $ds_key);
                break;
            case 'execute':
                $ret = $this->magicService->execute($db_key, $ds_key);
                break;
        }

        return response()->json($ret, 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    /**
     * Display the specified resource.
     *
     * @param $ds_id
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($ds_id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $ds_key
     * @param int $id
     * @return void
     */
    public function update(Request $request, $ds_key, $ds_id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $ds_key
     * @param int $id
     * @return void
     */
    public function destroy($ds_key, $ds_id)
    {
        //
    }
}
