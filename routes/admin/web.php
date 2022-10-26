<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\PublisherController;
use App\Http\Controllers\Admin\BorrowController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ImportController;

Route::group([
    'prefix'     => 'admin',
    'as'         => 'admin.',
    'middleware' => ['auth', 'verified', 'role:Admin|Petugas']], function () {

    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('category/get-dataTables', [CategoryController::class, 'getDataTables'])->name('category.dataTables');

    Route::resource('category', CategoryController::class);

    Route::get('member/get-dataTables', [MemberController::class, 'getDataTables'])->name('member.DataTables');

    Route::get('member/ajax-search', [MemberController::class, 'ajaxSearch'])->name('member.ajax-search');

    Route::resource('member', MemberController::class);

    Route::get('book/get-ajax-modal/{id}', [BookController::class, 'ajaxModal'])->name('book.ajax-modal');

    Route::get('book/get-dataTables', [BookController::class, 'getDataTables'])->name('book.dataTables');

    Route::get('book/get-barcode/{id}', [BookController::class, 'barcode'])->name('book.barcode');

    Route::get('book/ajax-search', [BookController::class, 'ajaxSearch'])->name('book.ajax-search');

    Route::get('book/cek-isbn/{isbn}', [BookController::class, 'cekIsbn'])->name('book.cek-isbn');

    Route::resource('book', BookController::class);

    Route::get('location/get-dataTables', [LocationController::class, 'getDataTables'])->name('location.dataTables');

    Route::resource('location', LocationController::class);

    Route::get('author/get-ajax-modal', [AuthorController::class, 'ajaxModal'])->name('author.ajax-modal');

    Route::get('author/get-dataTables', [AuthorController::class, 'getDataTables'])->name('author.dataTables');

    Route::resource('author', AuthorController::class);

    Route::get('publisher/get-ajax-modal', [PublisherController::class, 'ajaxModal'])->name('publisher.ajax-modal');

    Route::get('publisher/get-dataTables', [PublisherController::class, 'getDataTables'])->name('publisher.dataTables');
    
    Route::resource('publisher', PublisherController::class);

    Route::get('borrow/return-modal/{id}', [BorrowController::class, 'returnModal'])->name('borrow.return-modal');

    Route::get('borrow/get-dataTables', [BorrowController::class, 'getDataTables'])->name('borrow.dataTables');

    Route::get('borrow/get-book/{id}', [BorrowController::class, 'getBook'])->name('borrow.get-book');

    Route::get('borrow/get-member/{id}', [BorrowController::class, 'getMember'])->name('borrow.get-member');

    Route::post('borrow/return/{id}', [BorrowController::class, 'return'])->name('borrow.return');

    Route::post('borrow/extend/{id}', [BorrowController::class, 'extend'])->name('borrow.extend');
    
    Route::resource('borrow', BorrowController::class);

    Route::post('gallery/create-folder', [GalleryController::class, 'createFolder'])->name('gallery.create-folder');

    Route::post('gallery/upload', [GalleryController::class, 'upload'])->name('gallery.upload');

    Route::post('gallery/delete', [GalleryController::class, 'delete'])->name('gallery.delete');

    Route::get('gallery/getDirectory', [GalleryController::class, 'getDirectory'])->name('gallery.getDirectory');

    Route::get('gallery/getFiles/{id_directory}', [GalleryController::class, 'getFiles'])->name('gallery.getFiles');

    Route::resource('gallery', GalleryController::class);

    Route::get('posts/getDataTables', [PostController::class, 'getDataTables'])->name('posts.getDataTables');

    Route::post('posts/upload', [PostController::class, 'upload'])->name('posts.upload');

    Route::resource('posts', PostController::class);

    Route::get('users/getDataTables', [UserController::class, 'getDataTables'])->name('users.getDataTables');

    Route::resource('users', UserController::class);

    Route::resource('setting', SettingController::class);

    Route::get('messages/getDataTables', [MessageController::class, 'getDataTables'])->name('messages.getDataTables');

    Route::get('messages/get-contact/{id}', [MessageController::class, 'getContact'])->name('messages.get-contact');

    Route::resource('messages', MessageController::class);

    Route::get('reports/members/export', [ReportController::class, 'member_export'])->name('reports.members.export');

    Route::get('reports/books/export', [ReportController::class, 'book_export'])->name('reports.books.export');

    Route::get('reports/book-induk/export', [ReportController::class, 'book_induk_export'])->name('reports.book-induk.export');

    Route::resource('reports', ReportController::class);

    Route::post('import/upload', [ImportController::class, 'upload'])->name('import.upload');

    Route::resource('import', ImportController::class);
});
