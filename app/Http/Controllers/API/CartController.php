<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\QuestionResource;
use App\Models\Cart;
use App\Models\Categories;
use App\Models\Classification;
use App\Models\Level;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function init()
    {
        $category = Categories::all();
        $level = Level::all();
        $classification = Classification::all();
        $questions = QuestionResource::collection(Question::all());
        return response()->json([
            'status' => 200,
            'category' => $category,
            'level' => $level,
            'classification' => $classification,
            'questions' => $questions
        ]);
    }

    public function addToCart(Request $request)
    {
        if (auth('sanctum')->check()) {

            $user_id = auth('sanctum')->user()->id;
            $question_id = $request->question_id;
            $question_quantity = $request->question_quantity;

            $questionCheck = Question::where('id', $question_id)->first();
            if ($questionCheck) {

                if (Cart::where('question_id', $question_id)->where('user_id', $user_id)->exists()) {
                    return response()->json([
                        'status' => 409,
                        'message' => $questionCheck->name . 'Запись существует в карте!'
                    ]);
                } else {
                    $cartItem = new Cart;
                    $cartItem->user_id = $user_id;
                    $cartItem->question_id = $question_id;
                    $cartItem->question_quantity = $question_quantity;
                    $cartItem->save();
                    return response()->json([
                        'status' => 201,
                        'message' => 'Запись добавлена в карту!'
                    ]);
                }


            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Нет такого вопроса!'
                ]);
            }


        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Зарегестрируйтесь или войдите!'
            ]);
        }
    }

    public function viewCart()
    {
        if (auth('sanctum')->check()) {
            $user_id = auth('sanctum')->user()->id;
            $cartItems = Cart::where('user_id', $user_id)->orderBy('id')->get();

            return response()->json([
                'status' => 200,
                'cart' => $cartItems
            ]);

        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Зарегестрируйтесь или войдите для просмотра!'
            ]);
        }
    }

    public function updateQuantity($cart_id, $scope)
    {
        if (auth('sanctum')->check()) {
            $user_id = auth('sanctum')->user()->id;
            $cartItems = Cart::where('id', $cart_id)->where('user_id', $user_id)->first();
            if ($scope == 'inc') {
                $cartItems->question_quantity += 1;
            } else if ($scope == 'dec') {
                $cartItems->question_quantity -= 1;
            }

            $cartItems->update();

            return response()->json([
                'status' => 200,
                'message' => 'Количество обновлено!'
            ]);

        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Зарегестрируйтесь или войдите!'
            ]);
        }
    }

    public function destroy($id)
    {
        if (auth('sanctum')->check()) {
            $user_id = auth('sanctum')->user()->id;
            $cartItems = Cart::where('id', $id)->where('user_id', $user_id)->first();
            if ($cartItems) {
                $cartItems->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Вопрос удален!'
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Нет такого вопроса!'
                ]);
            }


        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Зарегестрируйтесь или войдите!'
            ]);
        }
    }

    public function profile()
    {
        $users = DB::select('select count(questions.category_id), categories.name from questions LEFT JOIN categories on questions.category_id = categories.id  group by(categories.name)');
        return response()->json([
            'status' => 200,
            '$users' => $users
        ]);
    }
}
