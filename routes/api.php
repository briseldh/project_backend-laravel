<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\GetDataController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Models\Post;
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


//=================Public Routes=================//
Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);
Route::post('/logout', LogoutController::class);
Route::get('/post/getAll', [PostController::class, 'getAll']);



Route::middleware('auth:web')->group(function () {

    Route::controller(GetDataController::class)->group(function () {

        Route::get('/getUserData', 'getUserData');
        Route::get('/getUser/{user}', 'getUserById');
    });

    Route::controller(PostController::class)->group(function () {

        Route::post('/post/insert', 'insert');
        Route::patch('/post/update/{id}', 'update');
        Route::delete('/post/delete/{id}', 'delete');
        Route::get('/post/getById/{id}', 'getById');
        // Route::get('/post/getAll', 'getAll');
        // Route::post('/post/uploadFile/{postId}', 'uploadFile');
        // Route::post('/post/{post}/like', 'like');
        // Route::post('/post/{post}/dislike', 'dislike');
    });

    Route::controller(CommentController::class)->group(function () {

        Route::post('/comment/insert/{post}', 'insert');
        Route::patch('/comment/update/{id}', 'update');
        Route::delete('/comment/delete/{id}', 'delete');
        Route::get('/comment/getById/{id}', 'getById');
    });

    Route::controller(LikeController::class)->group(function () {
        Route::get('/like/getUserLikes', 'getUserLikes');
        Route::get('/like/getAll', 'getAll');
        Route::post('/like/{post}', 'like');
        Route::post('/dislike/{post}', 'dislike');
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


// <section className="p-12 xl:px-52 xl:py-12 ">
//           {noCommentSection ? (
//             <div
//               id="comment-off"
//               className="flex flex-col border border-black rounded-lg md:flex-row mt:[32px] sm:mt-[64px]"
//             >
//               <div>
//                 <img src={car} alt="car" />
//               </div>

//               <div className="px-5 pt-5 md:flex md:flex-col md:justify-between">
//                 <h1 className="text-xl font-bold">Post Title</h1>
//                 <p className="py-3 text-sm text-gray-600">
//                   Lorem ipsum dolor sit, amet consectetur adipisicing elit.
//                   Repudiandae praesentium necessitatibus.
//                 </p>
//                 <div className="flex flex-col-reverse items-center py-1 border border-black rounded-t-lg cursor-pointer">
//                   <h3 className="text-sm text-blue-700" onClick={handleClick}>
//                     Comments
//                   </h3>
//                   <img
//                     src={arrow}
//                     alt="arrow"
//                     className="pt-1 text-blue-700 -rotate-90"
//                   />

//                   {/* Comment Section  */}
//                   <div className="hidden">
//                     <p>Comments</p>
//                   </div>
//                 </div>
//               </div>
//             </div>
//           ) : (
//             <div
//               id="comment-on"
//               className="flex flex-col border border-black rounded-lg md:flex-row mt:[32px] sm:mt-[64px]"
//             >
//               <div className="">
//                 {/* <img className="show-user-posts-image" src={`${BASE_URL}/${post.image_path}`} alt={post.title} /> */}
//                 <img className="" src={car} alt="car" />
//               </div>

//               <div className="px-5 pt-5 md:flex md:flex-col md:gap-2 ">
//                 <h1 className="hidden text-xl font-bold">Post Title</h1>
//                 <p className="hidden py-3 text-sm text-gray-600">
//                   Lorem ipsum dolor sit, amet consectetur adipisicing elit.
//                   Repudiandae praesentium necessitatibus.
//                 </p>
//                 <div className="flex flex-col items-center py-1 border border-b-0 border-black rounded-t-lg cursor-pointer h-[350px]">
//                   <h3 className="text-sm text-blue-700" onClick={handleClick}>
//                     Comments
//                   </h3>
//                   <img
//                     src={arrow}
//                     alt="arrow"
//                     className="pt-1 text-blue-700 rotate-90 "
//                   />

//                   {/* Comment Section  */}
//                   <div className="flex flex-col items-center justify-center gap-4 ">
//                     <form
//                       onSubmit={handleSubmit(onSubmit, onError)}
//                       noValidate
//                       className="w-[90%] flex flex-col justify-start gap-1 "
//                     >
//                       <label htmlFor="comment">Write a comment:</label>
//                       <input
//                         className="w-full h-10 p-2 border-2 border-gray-300 rounded-2xl"
//                         type="text"
//                         {...register("text", {})}
//                       />
//                       <Button
//                         styles="w-[30%] md:w-[40%] p-1 text-white text-xs bg-slate-500 rounded drop-shadow-md"
//                         disabled={isSubmitting}
//                         value="Submit"
//                         type="submit"
//                         onClick={() => null}
//                       />
//                     </form>
//                     <div className="flex w-full h-auto gap-2 p-2 border border-black">
//                       <div className="w-[30%]">
//                         <img
//                           className="object-contain"
//                           src={profile}
//                           alt="profile-pic"
//                         />
//                       </div>
//                       <div className="flex flex-wrap gap-2">
//                         <h1 className="text-sm font-semibold">John Doe</h1>
//                         <p className="text-xs text-gray-600">dd/mm/yy</p>
//                         <p className="text-xs text-gray-600">
//                           Lorem ipsum dolor sit amet.
//                         </p>
//                       </div>
//                     </div>
//                   </div>
//                 </div>
//               </div>
//             </div>
//           )}
//         </section>;
