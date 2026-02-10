<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EtablissementController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\SessionExamenController;
use App\Http\Controllers\SemestreController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\LotCopieController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DA\DashboardController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Page d'accueil
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Authentification
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}', [AdminUserController::class, 'show'])->name('admin.users.show');
    Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
});


/* Connexion */
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| Dashboard (APRÈS LOGIN)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profil utilisateur
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/profile', [UserController::class, 'profile'])->name('profile');

    Route::put('/profile/update', [UserController::class, 'update'])
        ->name('profile.update');

    Route::post('/profile/delete', [UserController::class, 'destroy'])
        ->name('profile.delete');

});

// dashboard DA

Route::get('/dashboard', function() {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

/* route qui gère auto index, create, store, show, edit update, destroy en meme temps 
avec les methodes GET, POST PUT/PATCH etc concerné en fonction de chaque action (index, sotre ...)
*/
Route::resource('etablissements', EtablissementController::class);

Route::resource('departements', DepartementController::class);

Route::resource('options', OptionController::class);

Route::resource('session_examens', SessionExamenController::class);

Route::resource('semestres', SemestreController::class);

Route::resource('modules', ModuleController::class);

Route::resource('lot-copies', LotCopieController::class);

Route::resource('notifications', NotificationController::class)->only(['index', 'show']);


