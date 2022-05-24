<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use App\Models\listing;
use Illuminate\Support\Facades\Route;

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
Route::group(['middleware' => ['auth']],function(){
    Route::get ( '/listings/{listing}/edit', [ListingController::class, 'edit'   ]);
    Route::get ('/listings/{listing}/update',[ListingController::class, 'update' ]);
    Route::delete('/listings/{listing}',     [ListingController::class, 'destroy']);
    Route::get ('/listings/create',          [ListingController::class, 'create' ]);
    Route::get ('/listings/manage',          [ListingController::class,  'manage']);
    Route::post('/listings',                 [ListingController::class, 'store'  ]);
    Route::post('/logout',                   [UserController::class,     'logout']);
});

Route::group(['middleware' => ['guest']],function(){
    Route::get ('/register',                 [UserController::class,     'create' ]);
    Route::get ('/login',                    [UserController::class,     'login'  ])->name('login');
});

Route::get ('/',                             [ListingController::class, 'index'   ]);
Route::get ('/listings/{listing}',           [ListingController::class, 'show'    ]);
Route::post('/userAuthenticate',             [UserController::class,'authenticate']);
Route::post('/users',                        [UserController::class,     'store'  ]);


//simple
// Route::get('/listings/{id}', function($id){
//     $listing = listing::find($id);
//     if($listing){
//         return view('listing',[
//             'listing' => $listing
//         ]);
//     }
//     else{
//         abort('404');
//     }
// });

// Route Model Binding
// Route model binding has the functionality of abort 404
// Route::get('/listings/{listing}', function(Listing $listing){
//         return view('listing',[
//             'listing' => $listing
//         ]);
// });


