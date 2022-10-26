<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PollingController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;

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

Route::get('/', HomeController::class)->name('beranda');

Route::post('polling/simpan', [ PollingController::class, "simpan" ])->name('polling');

Route::get('categories/{slug}', [CategoriesController::class, 'getBooks'])->name('categories');

Route::get('books/{slug}', [BooksController::class, 'getBook'])->name('books');

Route::get('search', [BooksController::class, 'search'])->name('search');

Route::resource('contact', ContactController::class);

Route::get('about', [PageController::class, 'about'])->name('about');

Route::get('notification', NotificationController::class)->middleware(['auth'])->name('notification');

Route::group(['middleware' => ['auth', 'verified', 'role:Member']], function () 
{   
    Route::get('profile/borrow/get-dataTables', [ProfileController::class, 'getDataTables'])->name('profile.borrow.dataTables');
 
    Route::post('profile/updateProfileInformation', [ProfileController::class, 'updateProfileInformation'])->name('profile.updateProfileInformation');

    Route::post('profile/updatePassword', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    Route::resource('profile', ProfileController::class);
    
    Route::resource('cart', CartController::class);
});

require __DIR__.'/auth.php';
require __DIR__.'/admin/web.php';
