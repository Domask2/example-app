<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\Api\DataBaseController;
use App\Http\Controllers\Api\DataSourceController;
use App\Http\Controllers\Api\DataSourceFieldController;
use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\Free\InitFreeController;
use App\Http\Controllers\Api\Free\ProjectFreeController;
use App\Http\Controllers\API\FrontendController;
use App\Http\Controllers\Api\InitController;
use App\Http\Controllers\Api\NewPasswordController;
use App\Http\Controllers\API\NewUserController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\Magic\MagicController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\SettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//use App\Http\Controllers\PermcatController;
//use App\Http\Controllers\PermissionController;
//use App\Http\Controllers\RoleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware(['auth:sanctum', 'verified'])->get('/user', function (Request $request) {
    return $request->user();
});
//---------------------------MY PROJECT---------------------------

Route::prefix('category')->group(function () {
    Route::get('/index', [CategoryController::class, 'index']);
});

Route::prefix('category')->middleware('auth:sanctum')->group(function () {
    Route::post('/store', [CategoryController::class, 'store']);
    Route::get('/edit/{id}', [CategoryController::class, 'edit']);
    Route::put('/update/{id}', [CategoryController::class, 'update']);
    Route::delete('/destroy/{id}', [CategoryController::class, 'destroy']);
});

Route::prefix('question')->middleware('auth:sanctum')->group(function () {
    Route::post('/store', [QuestionController::class, 'store']);
    Route::get('/edit/{id}', [QuestionController::class, 'edit']);
    Route::put('/update/{id}', [QuestionController::class, 'update']);
    Route::delete('/destroy/{id}', [QuestionController::class, 'destroy']);
});

Route::prefix('free')->group(function () {
    Route::get('init', [CartController::class, 'init']);
});



//---------------------------END MY PROJECT---------------------------


//My admin
Route::post('newUser', [NewUserController::class, 'newUser']);
Route::get('fetchQuestion/{id}', [FrontendController::class, 'question']);
Route::get('fetchQuestionId/{slug}/{id}', [FrontendController::class, 'viewQuestionId']);
Route::get('getCategory', [FrontendController::class, 'category']);
Route::post('addQuantityQuestion', [CartController::class, 'addToCart']);
Route::get('cart', [CartController::class, 'viewCart']);
Route::put('cartUpdateQuantity/{cart_id}/{scope}', [CartController::class, 'updateQuantity']);
Route::delete('deleteCartItem/{id}/', [CartController::class, 'destroy']);
//-----------------------------------------------------------------------

//Profile
Route::get('profile', [CartController::class, 'profile']);
//-----------------------------------------------------------------------

//My login
Route::get('/login/{provider}', [AuthController::class, 'redirectToProvider']);
Route::get('/login/{provider}/callback', [AuthController::class, 'handleProviderCallback']);

Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');
Route::get('email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
//-----------------------------------------------------------------------

Route::prefix('auth')->group(function () {
    Route::post('register', RegisterController::class);
    Route::post('login', [AuthController::class, 'login']);
//  My forgot password
    Route::post('forgot-password', [NewPasswordController::class, 'forgotPassword']);
    Route::post('reset-password', [NewPasswordController::class, 'reset']);
//-----------------------------------------------------------------------
});

Route::prefix('auth')->middleware('auth:sanctum')->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('revocation', [AuthController::class, 'revocation']);
});

Route::prefix('free')->group(function () {
    Route::get('project', [ProjectFreeController::class, 'index']);
    Route::get('project/{id}/pages', [ProjectFreeController::class, 'getPages']);
    Route::get('init', [InitFreeController::class, 'index']);

    Route::get('/mc/{db_key}/{ds_key}', [MagicController::class, 'index'])->name('mc.index');
    Route::post('/mc/{db_key}/{ds_key}', [MagicController::class, 'store'])->name('mc.store');

    Route::get('init', [CartController::class, 'init']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('project', ProjectController::class);
    Route::get('project/{id}/pages', [ProjectController::class, 'getPages']);
    Route::resource('page', PageController::class);
    Route::resource('db', DataBaseController::class);
    Route::resource('ds', DataSourceController::class);
    Route::resource('dsf', DataSourceFieldController::class);
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show']);

    //user profile
    # Route::post('user/{id}', UserController::class);

    Route::resource('setting', SettingController::class);

    Route::get('init', [InitController::class, 'index']);

    Route::get('/mc/{db_key}/{ds_key}', [MagicController::class, 'index'])->name('mc.index');
    Route::post('/mc/{db_key}/{ds_key}', [MagicController::class, 'store'])->name('mc.store');

//  Questions
    Route::post('/questions', [QuestionController::class, 'store']);
    Route::get('/view-questions', [QuestionController::class, 'index']);
    Route::get('/edit-questions/{id}', [QuestionController::class, 'edit']);
    Route::post('/update-questions/{id}', [QuestionController::class, 'update']);
    Route::delete('/delete-questions/{id}', [QuestionController::class, 'destroy']);
//-----------------------------------------------------------------------


//  permissions and roles
//  Route::resource('/permcats', PermcatController::class);
//  Route::resource('/permissions', PermissionController::class);
//  Route::resource('/roles', RoleController::class);

//  users
    Route::resource('/users', UserController::class);
});

/**
 * ========================================= Magic =========================================
 * SHOW
 * Реализуется через mc.index с передачей параметров фильтрации
 *
 * UPDATE
 * Реализуется через mc.store с передачей параметра where
 * Будет отредактирована первая запись (если под условие попали несколько)
 *
 * DELETE
 * Реализуется через mc.store с передачей параметров where и method='delete'
 */
/**
 * ========================================= Magic =========================================
 */
