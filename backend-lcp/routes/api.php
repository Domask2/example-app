<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DataBaseController;
use App\Http\Controllers\Api\DataSourceAccessController;
use App\Http\Controllers\Api\DataSourceController;
use App\Http\Controllers\Api\DataSourceFieldController;
use App\Http\Controllers\Api\DownloadController;
use App\Http\Controllers\Api\Free\InitFreeController;
use App\Http\Controllers\Api\Free\ProjectFreeController;
use App\Http\Controllers\Api\InitController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Magic\MagicController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PermcatController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;


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

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

});

/**
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
*/

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
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('project', ProjectController::class);
    Route::post('projectRemote', [ProjectController::class, 'storeRemote']);
    Route::post('projectFormData', [ProjectController::class, 'projectFormData']);
    Route::get('project/{id}/pages', [ProjectController::class, 'getPages']);
    Route::resource('page', PageController::class);
    Route::post('pageRemote', [PageController::class, 'storeRemote']);
    Route::post('pageRemoteAll', [PageController::class, 'storeRemoteAll']);
    Route::resource('db', DataBaseController::class);
    Route::resource('ds', DataSourceController::class);
    Route::resource('dsf', DataSourceFieldController::class);
    Route::resource('dsa', DataSourceAccessController::class);
    Route::post('allDs', [DataSourceController::class, 'allDs']);

    //download
    Route::get('download/{type}/{project}/{page}', [DownloadController::class, 'showTypeProjectPage']);
    Route::get('download/{type}/{project}', [DownloadController::class, 'showTypeProject']);
    Route::get('download/{type}', [DownloadController::class, 'showType']);
    Route::get('uniqueProject', [DownloadController::class, 'uniqueProject']);
    Route::get('uniquePage/{page}', [DownloadController::class, 'uniquePage']);
    Route::get('uniqueUserElement/{element}', [DownloadController::class, 'uniqueUserElement']);
    Route::get('uniquePageElement/{element}', [DownloadController::class, 'uniquePageElement']);
    Route::get('uniquePageElementItem/{item}', [DownloadController::class, 'uniquePageElementItem']);
    Route::post('downloadInProject', [DownloadController::class, 'downloadInProject']);
    Route::post('updateFiles', [DownloadController::class, 'updateFiles']);
    Route::post('destroyFiles', [DownloadController::class, 'destroyFiles']);
    Route::resource('download', DownloadController::class);

    Route::resource('setting', SettingController::class);
    Route::get('init', [InitController::class, 'index']);
    Route::get('/mc/{db_key}/{ds_key}', [MagicController::class, 'index'])->name('mc.index');
    Route::post('/mc/{db_key}/{ds_key}', [MagicController::class, 'store'])->name('mc.store');

    // permissions and roles
    Route::resource('/permcats', PermcatController::class);
    Route::resource('/permissions', PermissionController::class);
    Route::resource('/roles', RoleController::class);
    // users
    Route::resource('/users', UserController::class);
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show']);
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
