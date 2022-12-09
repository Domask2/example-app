<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Categories::orderBy('id')->get();
        return response()->json([
            'status' => 200,
            'category' => $category,
        ]);
    }

    public function edit($id)
    {
        $category = Categories::find($id);
        if($category) {
            return response()->json([
                'status' => 200,
                'category' => $category,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Нет такой категории',
            ]);
        }
    }

    public function store(Request $request)
    {
        if (Categories::where([['name', '=', $request->name], ['slug', '=', $request->slug]])->first()) {
            return response()->json([
                'status' => 400,
                'error' => 'Категория или slug уже существует',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'slug' => 'required|max:191',
                'name' => 'required|max:191',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->errors(),
                ]);
            } else {
                $category = new Categories;
                $category->slug = $request->slug;
                $category->name = $request->name;
                $category->description = $request->description;
                $category->save();

                return response()->json([
                    'status' => 200,
                    'category' => $category,
                    'message' => 'Категория успешно добавлена',
                ]);
            }
        }
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'slug' => 'required|max:191',
            'name' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ]);
        } else {
            $category = Categories::find($id);
            if($category) {
                $category->slug = $request->slug;
                $category->name = $request->name;
                $category->description = $request->description;
                $category->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Категория успешно обновлена',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'error' => 'Категория не найдена',
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $category = Categories::find($id);
        if($category) {
            $category->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Категория успешно удалена',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'error' => 'Категория не найдена',
            ]);
        }
    }
}



