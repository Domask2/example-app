<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingCreateRequest;
use App\Http\Resources\Api\SettingResource;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * @return SettingResource
     */
    public function index()
    {
        $setting = Setting::first();
        return new SettingResource($setting);
    }

    /**
     * @param SettingCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SettingCreateRequest $request)
    {
        $data = $request->validated();
        if ($request->file('logo')) {
            $image = $request->file('logo')->storePublicly('udb8/logo');
            $data['logo'] = 'storage/' . $image;
        }

        $setting = Setting::updateOrCreate(
            ['project_key' => 'general'],
            $data
        );

        $setting->save();

        return response()->json($setting->toArray(), 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        dd('show');
        $ds = Setting::find($id);
        return response()->json($ds, 200);
    }

    /**
     * @param SettingCreateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SettingCreateRequest $request, $id)
    {
        dd('update');
        $setting = Setting::find($id);
        $setting->update($request->validated());
        return response()->json($request, 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        dd('destroy');
        Setting::find($id)->delete();
        return response()->json('Deletion was successful', 200);
    }
}
