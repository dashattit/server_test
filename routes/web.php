<?php

use Src\Route;

// Общие маршруты
Route::add('GET', '/', [Controller\SiteController::class, 'index']);
Route::add(['GET', 'POST'], '/signup', [Controller\AuthController::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\AuthController::class, 'login']);
Route::add('GET', '/logout', [Controller\AuthController::class, 'logout']);
Route::add('GET', '/books', [Controller\BooksController::class, 'index']);

// Маршруты для авторизованных пользователей
Route::add(['GET', 'POST'], '/authors', [Controller\AuthorsController::class, 'index'])->middleware('auth');
Route::add(['GET', 'POST'], '/authors/create', [Controller\AuthorsController::class, 'create'])->middleware('auth');
Route::add(['GET', 'POST'], '/books/create', [Controller\BooksController::class, 'create'])->middleware('auth');
Route::add(['GET', 'POST'], '/books/issue', [Controller\BookDeliveriesController::class, 'issue'])->middleware('auth');
Route::add(['GET', 'POST'], '/books/accept', [Controller\BookDeliveriesController::class, 'accept'])->middleware('auth');
Route::add(['GET', 'POST'], '/readers', [Controller\ReadersController::class, 'index'])->middleware('auth');
Route::add(['GET', 'POST'], '/readers/create', [Controller\ReadersController::class, 'create'])->middleware('auth');


// Маршруты для администраторов
Route::add('GET', '/librarians', [Controller\LibrariansController::class, 'index'])->middleware('auth', 'isAdmin');
Route::add(['GET', 'POST'], '/librarians/create', [Controller\LibrariansController::class, 'create'])->middleware('auth', 'isAdmin');