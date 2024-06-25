<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Route::get('/', function ()
//{
//    $user=DB::connection('mysql2')->table('users')->get();
//    dd($user);
//});
