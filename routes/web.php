<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Track;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('admin.dashboard');
});
Route::get('/table', function () {
    return view('pie');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/category',[Track::class,"showcate"]);
Route::post('/insertcate',[Track::class,"insertcate"]);
Route::get('/pie',[Track::class,'chart']);
Route::get('/addcategory',[Track::class,'category']);
Route::get('/editcate/{id}',[Track::class,'editcate']);
Route::post('/updatecate',[Track::class,'updatecate']);
Route::get('/delecate/{id}',[Track::class,'delecate']);
Route::get('/addproduct',[Track::class,'product']);
Route::get('/assets',[Track::class,'showpro']);
Route::post('/insertpro',[Track::class,'insertpro']);
Route::get('/editpro/{id}',[Track::class,'editpro']);
Route::post('/updatepro',[Track::class,'updatepro']);
Route::get('/delepro/{id}',[Track::class,'delepro']);
Route::get('/imge/{id}',[Track::class,'imgLoad']);
Route::post('/uploadd',[Track::class,'uploadd']);
Route::get('/showimg/{id}',[Track::class,'showimg']);
Route::get('/bar',[Track::class,'bar']);