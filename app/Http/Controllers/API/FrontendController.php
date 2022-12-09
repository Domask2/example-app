<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Question;
use App\Services\Magic\MagicService;

class FrontendController extends Controller
{
    public function question($id)
    {
        $category = Categories::where('id', $id)->first();
        if ($category) {
            $question = Question::where('category_id', $category->id)->orderBy('id')->get();
            if ($question) {
                return response()->json([
                    'status' => 200,
                    'question_data' => [
                        'category' => $category,
                        'question' => $question
                    ]


                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Нет вопросов!'
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Нет такой категорий'
            ]);
        }
    }

    public function category()
    {
        $category = Categories::where('status', '0')->get();
        return response()->json([
            'status' => 200,
            'category' => $category
        ]);
    }

    protected function viewQuestionId($slug, $id)
    {
        $category = Categories::where('slug', $slug)->first();
        if ($category) {
            $question = Question::where('id', $id)->first();
            if ($question) {
                return response()->json([
                    'status' => 200,
                    'question' => $question
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Нет вопроса!'
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Нет такой категорий'
            ]);
        }
    }
}
