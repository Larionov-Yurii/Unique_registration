<?php

use App\Http\Controllers\UserRegisterController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\EventLinkController;
use App\Http\Controllers\EventNumbersController;
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


Route::name('user.')->group(function () {

    // Start page with registration and redirect to the page that contains a button with a unique link
    Route::get('/', [UserRegisterController::class, 'startPage'])->name('start-registration');

    // User creation
    Route::post('/user-creation', [UserRegisterController::class, 'createUser'])->name('sign-up');

    // Login page with login and redirect to the page that contains a button with a unique link
    Route::get('/login-page', [UserLoginController::class, 'loginPage'])->name('start-login');

    // Logging in User
    Route::post('/user-login', [UserLoginController::class, 'userLogin'])->name('sign-in');

    Route::middleware('auth')->group(function () {
        // Intermediate page that has a button to go to special page A
        Route::get('/transition-page', [EventLinkController::class, 'transitionPage'])->name('link-page');

        // Transition to page A with a unique link button
        Route::get('/transition-page/transitioning', [EventLinkController::class, 'transitionToPageA'])->name('transition-via-click');

        // Special page A
        Route::get('/special-page-a/{token}', [EventNumbersController::class, 'eventPage'])->name('events-page');

        // Random number generation
        Route::post('/special-page-a/start-event', [EventNumbersController::class, 'imFeelingLucky'])->name('post-event');

        // Getting information about the last three results of button clicks imFeelingLucky
        Route::get('/get-history', [EventNumbersController::class, 'getHistory'])->name('get-history');

        // Creating a new unique link
        Route::post('/special-page-a/create-link', [EventNumbersController::class, 'createUniqueLink'])->name('create-link');

        // Deactivating the current link
        Route::post('/special-page-a/delete-link', [EventNumbersController::class, 'deactivateUniqueLink'])->name('delete-link');

        // Logout
        Route::post('/logout', [EventNumbersController::class, 'userLogout'])->name('logout');
    });
});
