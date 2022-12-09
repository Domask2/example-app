<?php


namespace App\Services;

use App\Models\Page;
use App\Models\Page as Model;

class PageService extends CoreService
{
    /**
     * @return mixed|string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    public function createPage($project, $data)
    {

        $deletePage = Page::where("project_id", $project->id)->where('key', $data['key']);

        if ($deletePage) {
            $deletePage->delete();
        }

        $data['project_id'] = $project->id;
        unset($data['project_key']);
        return Page::create($data);
    }

    public function createPagesAll($fields, $project)
    {
        $result = [];

        $deletePage = Page::where("project_id", $project->id);
        if ($deletePage) {
            $deletePage->delete();
        }

        foreach ($fields as $item) {
            unset($item['remote']);
            $page['project_id'] = $project->id;
            $page["title"] = $item['title'];
            $page["key"] = $item['key'];
            $page["description"] = $item['description'];
            $page["components"] = $item['components'];
            $page["datasources"] = $item['datasources'];
            $page["ls"] = $item['ls'];
            $page["fnc"] = $item['fnc'];
            $page["addictions"] = $item['addictions'];
            $page["fly_inputs_groups"] = $item['fly_inputs_groups'];
            $pageResult = Page::updateOrCreate(['key' => $item['key'], "project_id" => $project->id], $page);
            array_push($result, ...$pageResult->all());
        }
        return $result;
    }


}
