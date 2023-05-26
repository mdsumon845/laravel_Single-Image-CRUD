<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;

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
    //Member image Crud
Route::get('/', [MemberController::class,'index']);
Route::post('/store/member', [MemberController::class,'store'])->name('store.member');
Route::get('/show/member', [MemberController::class,'show'])->name('member.list');
Route::get('/edit/member/{id}', [MemberController::class,'getMemberById'])->name('edit.member');
Route::post('/update/member', [MemberController::class,'updateMemberById'])->name('update.member');
Route::get('/delete/member/{id}', [MemberController::class,'deleteMemberById'])->name('delete.member');


