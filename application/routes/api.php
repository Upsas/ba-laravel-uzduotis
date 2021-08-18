<?php

use App\Http\Controllers\ApiContactsController;
use App\Http\Controllers\ApiSharedContactsController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resource('/contacts', ApiContactsController::class);
    Route::get('/contacts/search/{queryParam}', [ApiContactsController::class, 'search']);
    Route::get('/sharedContacts', [ApiSharedContactsController::class, 'getSharedContacts']);
    Route::get('/sharedContacts/users', [ApiSharedContactsController::class, 'getAccountsToShare']);
    Route::post('/sharedContacts/share/{contactId}/{userId}', [ApiSharedContactsController::class, 'share']);
    Route::post('/sharedContacts/add/{contactId}', [ApiSharedContactsController::class, 'addSharedContact']);
    Route::delete('/sharedContacts/{id}', [ApiSharedContactsController::class, 'deleteSharedContact']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//




