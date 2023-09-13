<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\Manjam\CategoriesController;
use Illuminate\Support\Facades\Route;
use JeffGreco13\FilamentBreezy\Http\Livewire\Auth\ResetPassword;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index']);


Route::get('/language/{locale}', function ($locale) {
    session()->put('locale', $locale);
    return redirect()->back();
})->name('language.switch');


Route::get('/paths/{id}', [HomeController::class, 'path']);

Route::get('/about', [HomeController::class, 'about']);

Route::get('/contact', [HomeController::class, 'contact']);

Route::get('/reset-passwords/{token}', ResetPassword::class)->middleware(['guest'])->name('password.reset');

Route::get('/test', function () {
    return "test";
});

Route::get('/termsandconditions', function () {
    return view('frontend.terms');
});


Route::view('/manjam', 'frontend.manjam');

Route::get('/manjam/talent_type/{talent_type}', \App\Http\Livewire\Manjam\TalentType::class);


// MANJAM
Route::get('/manjam/categories', [CategoriesController::class, 'index'])->name('manjam.all_categories');
Route::get('/manjam/categories/{talent_type}', [CategoriesController::class, 'show']);
