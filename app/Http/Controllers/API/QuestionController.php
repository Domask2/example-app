<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\QuestionResource;
use App\Models\Categories;
use App\Models\Classification;
use App\Models\Level;
use Illuminate\Support\Str;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    //            $settings_logo = Setting::first();
    //            if($settings_logo->logo) {
    //            $str = $settings_logo->logo;
    //            $str = str_replace('storage/', '', $str);
    //            Storage::delete($str);
    //            }

    public function index()
    {
        $questions = Question::orderBy('id')->get();
        return response()->json([
            'status' => 200,
            'questions' => $questions,
        ]);
    }

    public function edit($id)
    {
        $category = Question::find($id);
        if ($category) {
            return response()->json([
                'status' => 200,
                'question' => $category,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'question' => 'Нет такого вопроса!',
            ]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|max:191',
            'question' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ]);
        } else {
            $question = new Question;
            $question->slug = $request->input('slug');
            $question->key = Str::uuid();
            $question->category_id = $request->input('category_id');
            $question->level_id = $request->input('level_id');
            $question->classification_id = $request->input('classification_id');
            $question->question = $request->input('question');
            $question->answer = $request->input('answer');

//            if ($request->hasFile('image')) {
//                $file = $request->file('image');
//                $extension = $file->getClientOriginalExtension();
//                $chars = ['-', ':', ' '];
//                $str_name = str_replace($chars, '', Carbon::now());
//                $filename = $str_name . '.' . $extension;
//                $file->move('uploads/question/', $filename);
//                $question->image = 'uploads/question/' . $filename;
//            }

            $question->save();
            $question['category'] = Categories::where ('id', $question->category_id)->first()->name;
            $question['level'] = Level::where ('id', $question->level_id)->first()->level;
            $question['classification'] = Classification::where ('id', $question->classification_id)->first()->classification;
            return response()->json([
                'status' => 200,
                'question' => $question,
                'message' => 'Вопрос успешно добавлен!',
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|max:191',
            'slug' => 'required|max:191',
            'name' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ]);
        } else {
            $question = Question::find($id);
            if ($question) {
                $question->category_id = $request->input('category_id');
                $question->slug = $request->input('slug');
                $question->name = $request->input('name');
                $question->description = $request->input('description');

                $question->meta_title = $request->input('meta_title');
                $question->meta_keyword = $request->input('meta_keyword');
                $question->meta_descrip = $request->input('meta_descrip');

                $question->selling_price = $request->input('selling_price');
                $question->origin_price = $request->input('origin_price');
                $question->quantity = $request->input('quantity');
                $question->brand = $request->input('brand');

                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $chars = ['-', ':', ' '];
                    $str_name = str_replace($chars, '', Carbon::now());
                    $filename = $str_name . '.' . $extension;
                    $file->move('uploads/question/', $filename);
                    $question->image = 'uploads/question/' . $filename;
                }

                $question->featured = $request->featured == true ? '1' : '0';
                $question->popular = $request->popular == true ? '1' : '0';
                $question->status = $request->status == true ? '1' : '0';
                $question->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Вопрос успешно обновлен',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Вопрос не найден',
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $question = Question::find($id);
        if ($question) {
            $question->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Вопрос успешно удален',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Вопрос не найден',
            ]);
        }
    }
}

