<?php

use App\Http\Controllers\Admin\RequirementController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\HomeController as Home;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RuleController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\RequirementTypeController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\Admin\WeekdayController;

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

Route::get('/', [Home::class, 'index'])->name('home');
Route::post('/matriculas', [Home::class, 'postEnrollments'])->name('home.enrollments.post');
Route::get('/matriculas/{token}', [Home::class, 'getEnrollments'])->name('home.enrollments.get');
Route::post('/requerimento', [Home::class, 'postRequirements'])->name('home.requirements.post');
Route::get('/requerimento/{id}', [Home::class, 'getRequirements'])->name('home.requirements.get');

Route::get('faq', [Home::class, 'faq'])->name('faq');

Route::prefix('admin')->middleware(['auth', 'verified'])->group(function() {
    Route::get('/', [HomeController::class, 'index'])->name('admin');
    Route::resource('users', UserController::class);
    Route::get('users/{user}/edit/password', [UserController::class, 'editPassword'])->name('users.edit.password');
    Route::put('users/{user}/edit/password', [UserController::class, 'updatePassword'])->name('users.update.password');
    Route::get('profile', [UserController::class, 'profile'])->name('profile');
    Route::resource('rules', RuleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::get('permissions/{permission}/rules', [PermissionController::class, 'rules'])->name('permissions.rules');
    Route::put('permissions/{permission}/rules', [PermissionController::class, 'syncRules'])->name('permissions.rules.sync');
    Route::resource('groups', GroupController::class);
    Route::resource('activities', ActivityController::class)->only(['index', 'show', 'destroy']);
    Route::resource('faqs', FaqController::class);

    Route::resource('students', StudentController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('students.enrollments', EnrollmentController::class)->shallow();
    Route::resource('requirement/types', RequirementTypeController::class);
    Route::resource('semesters', SemesterController::class);
    Route::resource('weekdays', WeekdayController::class);
    Route::resource('requirements', RequirementController::class);
});

require __DIR__.'/auth.php';
