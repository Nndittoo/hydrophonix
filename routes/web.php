<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\UserPlantController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\LeaderboardController;

// [ADMIN] Import Controller
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\adminModuleController as AdminModuleController;
use App\Http\Controllers\Admin\adminQuizController as AdminQuizController;
use App\Http\Controllers\Admin\QuestionController as AdminQuestionController; // <-- [BARU]
use App\Http\Controllers\Admin\OptionController as AdminOptionController; // <-- [BARU]
use App\Http\Controllers\Admin\PlantController as AdminPlantController;
use App\Http\Controllers\Admin\PlantMissionController as AdminPlantMissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute Halaman Depan (Welcome)
Route::get('/', [WelcomeController::class, 'index'])->name("welcome");

// Rute untuk user yang sudah terautentikasi
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/plants', [PlantController::class, 'index'])->name('plants.index');
    Route::get('/plants/{plant}', [PlantController::class, 'show'])->name('plants.show');
    Route::get('/my-plant', [UserPlantController::class, 'index'])->name('user-plants.index');
    Route::post('/my-plant/start/{plant}', [UserPlantController::class, 'store'])->name('user-plants.store');
    Route::post('/my-plant/complete', [UserPlantController::class, 'completeMission'])->name('user-plants.complete');
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/calendar/events', [CalendarController::class, 'getEvents'])->name('calendar.events');
    Route::get('/modules', [ModuleController::class, 'index'])->name('modules.index');
    Route::get('/modules/{module:slug}', [ModuleController::class, 'show'])->name('modules.show');
    Route::get('/quiz/{quiz}', [QuizController::class, 'show'])->name('quiz.show');
    Route::post('/quiz/{quiz}', [QuizController::class, 'submit'])->name('quiz.submit');
    Route::get('/quiz/result/{attempt}', [QuizController::class, 'result'])->name('quiz.result');
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
});

// [ADMIN] Grup Rute Khusus Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('adminDashboard');

    Route::resource('plants', AdminPlantController::class);
    Route::resource('plants.missions', AdminPlantMissionController::class);

    // Admin Kelola Modul (CRUD)
    Route::resource('modules', AdminModuleController::class);

    Route::prefix('quizzes')->name('quizzes.')->group(function () {
        Route::get('/', [AdminQuizController::class, 'index'])->name('index');
        Route::get('/create', [AdminQuizController::class, 'create'])->name('create');
        Route::post('/', [AdminQuizController::class, 'store'])->name('store');
        Route::get('/{quiz}/edit', [AdminQuizController::class, 'edit'])->name('edit');
        Route::put('/{quiz}', [AdminQuizController::class, 'update'])->name('update');
        Route::delete('/{quiz}', [AdminQuizController::class, 'destroy'])->name('destroy');

        // Rute untuk menambah pertanyaan (AJAX)
        Route::post('/{quiz}/questions', [AdminQuestionController::class, 'store'])->name('questions.store');
    });

    // Rute untuk mengelola Pertanyaan & Pilihan Jawaban
    Route::delete('/questions/{question}', [AdminQuestionController::class, 'destroy'])->name('questions.destroy');
    Route::post('/questions/{question}/options', [AdminOptionController::class, 'store'])->name('options.store');
    Route::put('/options/{option}', [AdminOptionController::class, 'update'])->name('options.update');
    Route::delete('/options/{option}', [AdminOptionController::class, 'destroy'])->name('options.destroy');
    Route::patch('/questions/{question}/options/{option}/set-correct', [AdminOptionController::class, 'setCorrect'])->name('options.setCorrect');

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::patch('/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])->name('toggleAdmin');
        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
    });
});


require __DIR__ . '/auth.php';
