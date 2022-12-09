<?php


namespace App\Services;

use App\Models\Project;
use App\Models\Project as Model;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class SettingService extends CoreService
{
    /**
     * @return mixed|string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * @param $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function settingFromDateValidate($request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
            "title" => "max:100",
            "project_key" => "max:50",
        ]);

    }

    /**
     * @param Request $request
     * @return Model
     */
    public function saveSettingByFormData(Request $request)
    {
        if ($request->file('logo')) {
            $image = $request->file('logo')->storePubliclyAs('udb8/logo', 'logo.png');
            $data['logo'] = 'storage/'.$image;
        }

        if($request->input('logo') === 'delete') {
            $data['logo'] = null;
        }

        $data['project_key'] = 'general';
        $data['title'] = $request->input('title');
        $data['head_styles'] = $request->input('head_styles');
        $data['sys_vars'] = $request->input('sys_vars');

        $setting = Setting::updateOrCreate(
            ['project_key' => 'general'],
            $data
        );

        $setting->save();
        $setting['head_styles'] =json_decode($setting->head_styles);
        $setting['sys_vars'] =json_decode($setting->sys_vars);

        return $setting;
    }

}
