<?php

use App\Http\Controllers\GroupApplicationController;
use Carbon\Carbon;
use App\Models\Pool;
use App\Models\User;
use App\Models\Vote;
use App\Models\Option;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PoolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LikeController;
use App\Models\Group;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




// Pool routes 
Route::get('/',[PoolController::class,'index']);

Route::get('/pool/create',[PoolController::class,'create'])->middleware("auth");

Route::post('/pool/create',[PoolController::class,'savePool'])->middleware("auth");

Route::get('/pool/{pool}',[PoolController::class,'show'])->name('show')->middleware('groupmember');




//User routes
Route::get('/register',[UserController::class,'register'])->middleware("guest");

Route::post('/user/create',[UserController::class,'create'])->middleware("guest");;

Route::post('/logout',[UserController::class,'logout'])->middleware("auth");;

Route::get('/login',[UserController::class,'login'])->name('login')->middleware("guest");

Route::post('/authenticate',[UserController::class,'authenticate'])->middleware("guest");


//Vote route
Route::post('/vote/save',[VoteController::class,'saveVote'])->name('saveVote')->middleware('groupmember')->middleware("auth");

//Comment route
Route::post('/post/comment/{pool}',[CommentController::class,'saveComment'])->middleware("auth");
Route::delete('/comment/delete/{comment}',[CommentController::class,'deleteComment'])->middleware("auth");
Route::put('/comment/update/{comment}',[CommentController::class,'updateComment'])->middleware("auth");

//Like route
Route::post('/comment/likeorunlike',[LikeController::class,'likeOrUnlikeComment'])->middleware("auth");

//Groups route

Route::get('/groups',[GroupController::class,'index'])->middleware("auth");
Route::delete('/group/leave/{group}',[GroupController::class,'leave'])->middleware('auth')->middleware('groupmember');



Route::post('/group/application/create/{group}',[GroupApplicationController::class,'saveApplication'])->middleware('auth')->middleware('nongroupmember')->middleware('groupapplication');
Route::post('/group/application/accept/{group}/{user}',[GroupApplicationController::class,'acceptApplication'])->middleware('auth')->middleware('groupleader');
Route::delete('/group/application/decline/{application}',[GroupApplicationController::class,'declineApplication'])->middleware('auth')->middleware('groupleader');


Route::delete('/group/kick/{groupuser}',[GroupController::class,'kick'])->middleware('auth')->middleware('groupleader');


Route::put('/group/changeleader/{groupuser}',[GroupController::class,'leaderChange'])->middleware('auth')->middleware('groupleader');
Route::get('/group/application/{group}',[GroupApplicationController::class,'showApplications'])->middleware('auth')->middleware('groupleader');
Route::get('/group/create',[GroupController::class,'create'])->middleware("auth");
Route::post('/group/create',[GroupController::class,'save'])->middleware("auth");
Route::get('/group/{group}',[GroupController::class,'show'])->middleware("auth");


Route::fallback(function () {
    return redirect('/');
});

