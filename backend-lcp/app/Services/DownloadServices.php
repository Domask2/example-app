<?php

namespace App\Services;

use App\Models\Downloads;
use Illuminate\Support\Facades\Storage;

class DownloadServices extends CoreService
{
    /**
     * @return mixed|string
     */
    protected function getModelClass()
    {
        return Downloads::class;
    }

    public function addDownload($request)
    {
        $result = [];
        for ($i = $request->input('number'); $i > 0; $i--) {

            $file = $request->file('file' . $i);

            $date_now = new \DateTime('now', new \DateTimeZone('MSK'));
            $date_str = $date_now->format('YmdHis');

            $nameFile = $file->getClientOriginalName();
            $nameFileArray = explode('.', $nameFile);
            $nameFile = $date_str . '-' . $nameFileArray[0] . '.' . $nameFileArray[1];

            $path = $file->storeAs($request->input('url'), $nameFile, 'local');

            $data['key'] = $path;
            $data['user_id'] = auth()->user()->id;

            $data['file'] = $nameFile;
            $data['title'] = $request->input('title');
            $data['description'] = $request->input('description');

            $data['url'] = 'storage/' . $path;
            $data['project'] = $request->input('project');
            $data['project_page'] = $request->input('pages');

            $data['visible'] = $request->input('visible') === 'true' ? true : false;
            $download = Downloads::create($data);
            $result[] = $download;
        }

        return $result;
    }

    /**
     * @param $id
     * @return void
     * ToDo: ПЕРЕПИСАТЬ на рекурсию
     */
    public function deleteFileCatalog($id)
    {
        $download = Downloads::find($id);
        if ($download) {
            $str = $download->key;
            $path_file = explode("/", $str);
            unset ($path_file[count($path_file) - 1]);
            $str_path = implode("/", $path_file);
            Storage::delete($download->key);
            $download->delete();

            $files = Storage::Files($str_path);
            $directory = Storage::directories($str_path);
            if (count($files) === 0 && count($directory) === 0) {
                Storage::deleteDirectory($str_path);

                $str_file1 = explode('/', $str_path);
                if (count($str_file1) > 2) {
                    if ($str_file1[1] !== 'users' && $str_file1[1] !== 'lcp') {
                        unset ($str_file1[count($str_file1) - 1]);
                        $str_path1 = implode("/", $str_file1);
                        $files1 = Storage::Files($str_path1);
                        $directory1 = Storage::directories($str_path1);

                        if (count($files1) === 0 && count($directory1) === 0) {
                            Storage::deleteDirectory($str_path1);

                            $str_file2 = explode('/', $str_path1);
                            unset ($str_file2[count($str_file2) - 1]);
                            $str_path2 = implode("/", $str_file2);
                            $files2 = Storage::Files($str_path2);
                            $directory2 = Storage::directories($str_path2);

                            if (count($files2) === 0 && count($directory2) === 0) {
                                Storage::deleteDirectory($str_path2);

                                $str_file3 = explode('/', $str_path2);
                                unset ($str_file3[count($str_file3) - 1]);
                                $str_path3 = implode("/", $str_file3);
                                $files3 = Storage::Files($str_path3);
                                $directory3 = Storage::directories($str_path3);

                                if (count($files3) === 0 && count($directory3) === 0) {
                                    Storage::deleteDirectory($str_path3);
                                }
                            }
                        }
                    }
                }
            }
        }

        return $download;
    }
}
