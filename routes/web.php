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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SystemScanController;
use App\Models\Departement;
use App\Models\Option;
use App\Models\SessionExamen;

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

    Route::prefix('admin/users')->group(function () {

        // Formulaire d'import
        Route::get('/import', [AdminUserController::class, 'importForm'])
            ->name('admin.users.import.form');

        // Traitement import
        Route::post('/import', [AdminUserController::class, 'importProcess'])
            ->name('admin.users.import.process');

        // Routes classiques
        Route::get('/', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::get('/create', [AdminUserController::class, 'create'])->name('admin.users.create');
        Route::post('/', [AdminUserController::class, 'store'])->name('admin.users.store');
        Route::delete('/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    });

});



/* Connexion */
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


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

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/da', [DashboardController::class, 'da'])->name('dashboard.da');
Route::get('/dashboard/cd', [DashboardController::class, 'cd'])->name('dashboard.cd');
Route::get('/dashboard/cs', [DashboardController::class, 'cs'])->name('dashboard.cs');
Route::get('/dashboard/enseignant', [DashboardController::class, 'enseignant'])->name('dashboard.enseignant');
Route::get('/dashboard/president', [DashboardController::class, 'president'])->name('dashboard.president');
Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');

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

// Départements par établissement
Route::get('/api/departements/{etablissement}', function($id){
    return Departement::where('etablissement_id', $id)->get();
});

// Options par département
Route::get('/api/options/{departement}', function($id){
    return Option::where('departement_id', $id)->get();
});

// Sessions par option
Route::get('/api/sessions/{option}', function($id){
    return SessionExamen::whereHas('options', fn($q)=>$q->where('id', $id))->get();
});

Route::resource('notifications', NotificationController::class)->only(['index', 'show']);

Route::post('/system/scan', [SystemScanController::class, 'scan'])
    ->name('system.scan');

Route::get('/system/scan', [SystemScanController::class, 'scan'])->name('system.scan');
