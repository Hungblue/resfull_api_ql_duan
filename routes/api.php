<?php

use App\Http\Controllers\DeadlineController;
use App\Http\Controllers\EstimationController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailRemindController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ContractTypeController;
use App\Http\Controllers\AllowanceController;
use App\Http\Controllers\CheckPointController;
use App\Http\Controllers\HistoryCheckPointController;
use App\Http\Controllers\NewSkillController;
use App\Http\Controllers\AchievementWorkController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('auth/loginProvider', [PassportAuthController::class, 'loginProvider']);

Route::post('auth/register', [PassportAuthController::class, 'register']);
Route::post('auth/login', [PassportAuthController::class, 'login'])->name('login');
Route::middleware('auth:api')->post('auth/logout', [PassportAuthController::class, 'logout']);
Route::middleware('auth:api')->post('auth/change-password', [PassportAuthController::class, 'changePassword']);

Route::get('/test', [MasterController::class, 'testApi']);

Route::get('/master/{table_name}', [MasterController::class, 'getAll']);
Route::get('/role/all', [MasterController::class, 'getRoles']);
Route::get('/masterSkill', [SkillController::class, 'getAll']);
Route::delete('/masterSkill/delete/{id}', [SkillController::class, 'delete']);
Route::middleware('auth:api')->group(function () {
    Route::prefix('/projects')->group(function () {
        Route::get('/all-projects', [ProjectController::class, 'getAll']);
        Route::get('/{id}', [ProjectController::class, 'getDetailProject']);
        Route::post('/create', [ProjectController::class, 'store']);
        Route::put('/update/{id}', [ProjectController::class, 'update']);
        Route::delete('/delete/{id}', [ProjectController::class, 'delete']);
        Route::prefix('/deadlines')->group(function () {
            Route::get('/{id}', [DeadlineController::class, 'getDetail']);
            Route::post('/create', [DeadlineController::class, 'store']);
            Route::put('/update', [DeadlineController::class, 'update']);
            Route::delete('/delete/{id}', [DeadlineController::class, 'delete']);
        });
        Route::prefix('/resources')->group(function () {
            Route::get('/{id}', [ResourceController::class, 'getDetail']);
            Route::post('/create', [ResourceController::class, 'store']);
            Route::put('/update', [ResourceController::class, 'update']);
            Route::delete('/delete/{id}', [ResourceController::class, 'delete']);
        });
        Route::prefix('/estimations')->group(function () {
            Route::get('/{id}', [EstimationController::class, 'getDetail']);
            Route::post('/create', [EstimationController::class, 'store']);
            Route::put('/update', [EstimationController::class, 'update']);
            Route::delete('/delete/{id}', [EstimationController::class, 'delete']);
        });
    });
    Route::get('/all-deadlines', [DeadlineController::class, 'getAll']);
    Route::prefix('/users')->group(function () {
        Route::get('/all-users', [UserController::class, 'getAll']);
        Route::get('/all-users2', [UserController::class, 'getAllSearchable']);
        Route::get('/{id}', [UserController::class, 'getUser']);
        Route::put('/update/{id}', [UserController::class, 'update']);
        Route::post('/reset-password', [UserController::class, 'adminResetPassword']);
        Route::delete('/delete/{id}', [UserController::class, 'delete']);
    });
    Route::prefix('/email')->group(function () {
        Route::get('/all-emails', [EmailRemindController::class, 'getAll']);
        Route::post('/create', [EmailRemindController::class, 'create']);
        Route::get('send_mail', [UserController::class, 'send_mail']);
        Route::delete('/delete/{id}', [EmailRemindController::class, 'delete']);
        Route::put('/update/{id}', [EmailRemindController::class, 'update']);
    });

    Route::prefix('/skill')->group(function () {
        Route::get('/getSkill/{id}', [SkillController::class, 'getSkill']);
    });
    Route::prefix('/contract')->group(function () {
        Route::get('/all-contract', [ContractController::class, 'getAll']);
        Route::get('/detail-contract/{id}', [ContractController::class, 'detailContract']);
        Route::get('/history-contract/{id}', [ContractController::class, 'historyContract']);
        Route::post('/create', [ContractController::class, 'createContract']);
        Route::put('/update/{id}', [ContractController::class, 'updateContract']);
    });
    Route::get('/all-position', [PositionController::class, 'getAll']);
    Route::get('/all-allowance', [AllowanceController::class, 'getAll']);
    Route::get('/all-contract_type', [ContractTypeController::class, 'getAll']);
    Route::get('dashboard', [DashboardController::class, 'getDashboard']);

    Route::prefix('/check_point')->group(function () {
        Route::get('/all-check_point', [CheckPointController::class, 'getAll']);
        Route::get('/detail-check_point/{id}', [CheckPointController::class, 'detailCheckPoint']);
        Route::post('/create', [CheckPointController::class, 'createCheckPoint'])->middleware('CheckPoint');
        Route::put('/update/{id}', [CheckPointController::class, 'updateCheckPoint'])->middleware('CheckPoint');
        Route::delete('/delete/{id}', [CheckPointController::class, 'delete'])->middleware('CheckPoint');
    });
    Route::prefix('/history_check_point')->group(function () {
        Route::get('/all', [HistoryCheckPointController::class, 'getAll'])->middleware('CheckPoint');
        Route::get('/detail/{id}', [HistoryCheckPointController::class, 'detail']);
        Route::post('/create', [HistoryCheckPointController::class, 'createHistoryCheckPoint']);
        Route::delete('/delete/{id}', [HistoryCheckPointController::class, 'delete']);
        Route::get('/user_check_point/{id}', [HistoryCheckPointController::class, 'sumUserCheckPoint'])->middleware('CheckPoint');
    });

    Route::prefix('/new_skill')->group(function () {
        Route::get('/all', [NewSkillController::class, 'getAll']);
        Route::get('/detail/{id}', [NewSkillController::class, 'detailNewKill']);
        Route::post('/create', [NewSkillController::class, 'createNewSkill']);
        Route::put('/update/{id}', [NewSkillController::class, 'updateNewKill']);
        Route::delete('/delete/{id}', [NewSkillController::class, 'delete']);
    });

    Route::prefix('/achievement_work')->group(function () {
        Route::get('/all', [AchievementWorkController::class, 'getAll']);
        Route::get('/detail/{id}', [AchievementWorkController::class, 'detail']);
        Route::post('/create', [AchievementWorkController::class, 'create']);
        Route::put('/update/{id}', [AchievementWorkController::class, 'update']);
        Route::delete('/delete/{id}', [AchievementWorkController::class, 'delete']);
    });

});