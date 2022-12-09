<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Downloads;
use App\Repositories\DataBaseRepository;
use App\Services\DownloadServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DownloadController extends Controller
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, DownloadServices $downloadServices)
    {
        try {
            $result = $downloadServices->addDownload($request);
            return response()->json($result, 200);
        } catch (\Throwable $e) {
            return response()->json(false, 404);
        }
    }

    public function downloadInProject(Request $request, DownloadServices $downloadServices)
    {
        try {
            //ToDo: проверить все ли откатывается $downloadServices->addDownload($request); + DB::...
            DB::beginTransaction();
            $result = $downloadServices->addDownload($request);

            if ($result) {
                $dbRepository = new DataBaseRepository();
                $db = $dbRepository->findByKey($request->input('db_key'));
                Config::set("database.connections.udb", $db->toArray());
                $files_id = DB::connection('udb')->select(DB::raw("insert into lcp_files (path, title, description) values ('" . $result[0]->url . "', '" . $result[0]->title . "' ,'" . $result[0]->description . "') returning id"));
                DB::connection('udb')->select(DB::raw("insert into lcp_files_objects (object_id, album_id, file_id) values ('" . $request->input('object_id') . "', '" . $request->input('album_id') . "', '" . $files_id[0]->id . "');"));
            }

            DB:: commit();
            return response()->json(true, 200);

        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json($e, 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showTypeProjectPage($type, $project, $page)
    {
        if ($type === 'project') {
            if ($page) {
                $strPage = str_replace('=', '/', $page);
                $downloads = Downloads::where('project', $project)->where('project_page', $strPage)->orderBy('file')->get();
                return response()->json([
                    'status' => 200,
                    'downloads' => $downloads,
                    'message' => 'попали'
                ]);
            }
        }
    }

    public function showTypeProject($type, $project)
    {
        if ($type === 'project') {
            $downloads = Downloads::where('project', $project)->get();
            return response()->json([
                'status' => 200,
                'downloads' => $downloads,
            ]);
        }
    }

    public function showType($type)
    {
        if ($type === 'users') {
            $downloads = Downloads::where('project', 'users')->get();
            return response()->json([
                'status' => 200,
                'downloads' => $downloads,
            ]);
        } else if ($type === 'project') {
            $downloads = Downloads::where('project', '!=', 'users')->get();
            return response()->json([
                'status' => 200,
                'downloads' => $downloads,
                'message' => 'попали'
            ]);
        }
    }

    public function uniqueProject()
    {
        $downloadProject = DB::table('downloads')->
        select(DB::raw('DISTINCT project, COUNT(*) AS count'))->
        groupBy('project')->
        orderBy('project', 'desc')->
        get();
        return $downloadProject;
    }

    public function uniquePage($page)
    {
        if ($page === 'users') {
            $downloadPage = DB::table('downloads')->
            select(DB::raw('project_page AS title, COUNT(*) AS count, project_page as key'))->
            where('project', $page)->
            groupBy('project_page')->
            get();
        } else if ($page === 'lcp') {
            $downloadPage = Downloads::where('project', $page)->get();
        } else {
            $downloadPage = DB::table('downloads')->
            select(DB::raw('project AS title,  COUNT(*) AS count, project as key'))->
            where('project', '!=', 'lcp')->
            where('project', '!=', 'users')->
            groupBy('project')->
            get();
        }
        return $downloadPage;
    }

    public function uniqueUserElement($element)
    {
        $downloadPage = Downloads::where('project_page', $element)->get();
        return $downloadPage;
    }

    public function uniquePageElement($element)
    {
        $downloadPage = DB::table('downloads')->
        select(DB::raw('project_page AS title,  COUNT(*) AS count, project_page AS key'))->
        where('project', $element)->
        groupBy('project_page')->
        get();
        return $downloadPage;
    }

    public function uniquePageElementItem($item)
    {
        $str = str_replace('=', '/', $item);
        $downloadPage = Downloads::where('project_page', $str)->get();
        return $downloadPage;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Request
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Request
     */
    public function update(Request $request, $id)
    {
        $download = Downloads::find($id);
        $download->update($request->all());
        return $download;
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateFiles(Request $request)
    {
        try {
            DB::beginTransaction();

            $download = Downloads::where('url', $request->path)->first();

            if ($download) {
                $download->update($request->all());

                $dbRepository = new DataBaseRepository();
                $db = $dbRepository->findByKey($request->db_key);
                Config::set("database.connections.udb", $db->toArray());
                DB::connection('udb')->select(DB::raw("UPDATE lcp_files SET(title, description) = ('". $request->title ."' ,'".$request->description."') where id =" .$request->id));
            }

            DB:: commit();
            return response()->json(true, 200);

        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json($e, 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, DownloadServices $downloadServices)
    {
        try {
            $downloadServices->deleteFileCatalog($id);
            return response()->json('Файл успешно удален', 200);
        } catch (\Throwable $e) {
            return response()->json($e, 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyFiles(Request $request, DownloadServices $downloadServices)
    {
        try {
            //ToDo: проверить все ли откатывается $downloadServices->deleteFileCatalog($download->id); + DB::...
            DB::beginTransaction();

            $download = Downloads::where('url', $request->path)->first();

            if ($download) {
                $files = $downloadServices->deleteFileCatalog($download->id);

                if ($files) {
                    $dbRepository = new DataBaseRepository();
                    $db = $dbRepository->findByKey($request->db_key);
                    Config::set("database.connections.udb", $db->toArray());
                    DB::connection('udb')->select(DB::raw("delete from lcp_files where id =" . $request->id));
                }
            }

            DB:: commit();
            return response()->json(true, 200);

        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json($e, 404);
        }
    }
}
