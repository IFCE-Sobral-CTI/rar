<?php

use App\Http\Controllers\HomeController as Home;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RequirementController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CourseTypeController;
use App\Http\Controllers\Admin\DispatchController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RuleController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\PrintQueueController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RequirementReportController;
use App\Http\Controllers\Admin\RequirementTypeController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\Admin\WeekdayController;
use App\Http\Middleware\ValidatesReportAccessInHtml;
use App\Mail\CreateDispatchMail;
use App\Mail\SendToReprography;
use App\Mail\UpdateDispatchMail;
use App\Models\Dispatch;
use App\Models\Report;

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
    Route::resource('courses/types', CourseTypeController::class)->names('course_types');
    Route::resource('courses', CourseController::class);
    Route::resource('students.enrollments', EnrollmentController::class);
    Route::resource('requirement/types', RequirementTypeController::class);
    Route::resource('semesters', SemesterController::class);
    Route::resource('weekdays', WeekdayController::class);
    Route::resource('requirements', RequirementController::class);
    Route::get('reports/requirements', [RequirementReportController::class, 'index'])->name('requirement_reports.index');
    Route::resource('requirements.dispatches', DispatchController::class);
    Route::resource('print/queues', PrintQueueController::class)
        ->only(['index', 'show', 'destroy'])
        ->names('print_queues');
    Route::post('print/queues/send/report', [PrintQueueController::class, 'send'])->name('print_queues.send');

    Route::get('report/print/send/{report}', [ReportController::class, 'send'])->name('reports.send');
    Route::get('report/print/pdf/{report}', [ReportController::class, 'pdf'])->name('reports.pdf');
    Route::get('report/print/html/{report}', [ReportController::class, 'html'])->name('reports.html');


    Route::resource('print/reports', ReportController::class)
        ->only(['index', 'show', 'destroy', 'update']);
});

Route::get('report/print/html/{token}', [ReportController::class, 'htmlWithToken'])->name('reports.html.token')->middleware(ValidatesReportAccessInHtml::class);

Route::get('/mail', function() {
    $report = Report::find(5);
    $token = $report->tokens()->first();

    return new SendToReprography(report: $report, token: $token);
});

require __DIR__.'/auth.php';
