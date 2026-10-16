<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SpeakerController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

Route::middleware('auth')->group(function () {
    Route::post('/events/{event}/registration', [EventRegistrationController::class, 'store'])->name('events.registration.store');
    Route::delete('/events/{event}/registration', [EventRegistrationController::class, 'destroy'])->name('events.registration.destroy');
});

Route::get('/speakers', [SpeakerController::class, 'index'])->name('speakers.index');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{post}', [NewsController::class, 'show'])->name('news.show');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

Route::get('/programs/self-learning', [ProgramController::class, 'selfLearning'])->name('programs.self-learning');
Route::get('/programs/business-incubation', [ProgramController::class, 'incubation'])->name('programs.incubation');

Route::post('/newsletter', [NewsletterController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('newsletter.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
