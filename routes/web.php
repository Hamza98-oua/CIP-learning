<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StagiaireController;
use App\Http\Controllers\AdminResourceController;
use App\Http\Controllers\AdminUserController;

Route::get('/', function () {
    return redirect('/login');
});

// Authentification
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Stagiaire
Route::get('/stagiaire/dashboard', [StagiaireController::class, 'index'])->middleware(['auth'])->name('stagiaire.dashboard');

// Admin et Formateur - Utilisateurs
Route::get('/admin', [AdminUserController::class, 'dashboard'])->middleware(['auth', 'role:admin,formateur'])->name('admin.dashboard');

Route::get('/admin/users', [AdminUserController::class, 'index'])->middleware(['auth', 'role:admin,formateur'])->name('admin.users.index');
Route::get('/admin/users/create', [AdminUserController::class, 'create'])->middleware(['auth', 'role:admin,formateur'])->name('admin.users.create');
Route::post('/admin/users', [AdminUserController::class, 'store'])->middleware(['auth', 'role:admin,formateur'])->name('admin.users.store');
Route::get('/admin/users/{id}/edit', [AdminUserController::class, 'edit'])->middleware(['auth', 'role:admin,formateur'])->name('admin.users.edit');
Route::put('/admin/users/{id}', [AdminUserController::class, 'update'])->middleware(['auth', 'role:admin,formateur'])->name('admin.users.update');
Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy'])->middleware(['auth', 'role:admin,formateur'])->name('admin.users.destroy');

// Admin et Formateur - Ressources
Route::get('/admin/videos', [AdminResourceController::class, 'videos'])->middleware(['auth', 'role:admin,formateur'])->name('admin.resources.videos');
Route::get('/admin/pdfs', [AdminResourceController::class, 'pdfs'])->middleware(['auth', 'role:admin,formateur'])->name('admin.resources.pdfs');
Route::get('/admin/resources/create', [AdminResourceController::class, 'create'])->middleware(['auth', 'role:admin,formateur'])->name('admin.resources.create');
Route::post('/admin/resources', [AdminResourceController::class, 'store'])->middleware(['auth', 'role:admin,formateur'])->name('admin.resources.store');
Route::delete('/admin/resources/{id}', [AdminResourceController::class, 'destroy'])->middleware(['auth', 'role:admin,formateur'])->name('admin.resources.destroy');
