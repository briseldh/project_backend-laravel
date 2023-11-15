<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\GetDataController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);
Route::post('/logout', LogoutController::class);

Route::middleware('auth:web')->group(function () {

    Route::controller(GetDataController::class)->group(function () {

        Route::get('/getUserData', 'getUserData');
    });

    Route::controller(PostController::class)->group(function () {

        Route::post('/post/insert', 'insert');
        Route::patch('/post/update/{id}', 'update');
        Route::delete('/post/delete/{id}', 'delete');
        Route::get('/post/getById/{id}', 'getById');
        Route::get('/post/getAll', 'getAll');
        Route::post('/uploadFile/{postId}', 'uploadFile');
    });

    Route::controller(CommentController::class)->group(function () {

        Route::post('/comment/insert', 'insert');
        Route::patch('/comment/update/{id}', 'update');
        Route::delete('/comment/delete/{id}', 'delete');
        Route::get('/comment/getById/{id}', 'getById');
    });
});


Route::fallback(function () {
    return response()->json(['message' => 'Not Found'], 404);
});


// pm.sendRequest({
//     url: 'http://localhost/sanctum/csrf-cookie',
//     method: 'GET',
// }, (error, response) => {
//     console.log(error)
//     console.log(response.headers.all())

//     response.headers.all().find(( header ) => {
//         if(header.key === "Set-Cookie"){
//             if(header.value.startsWith("XSRF-TOKEN")){
//                 const pattern = new RegExp(`(?<=XSRF-TOKEN=)[^;]+`, 'g');
//                 const token = header.value.match(pattern)[0];
//                 const decodedToken = decodeURIComponent(token)
//                 pm.environment.set('xsrf-token', decodedToken)
//             }
//         }
//     });
// })
