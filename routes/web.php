<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Classroom\ClassroomController;
use App\Http\Controllers\Grades\GradesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Questions\QuestionController;
use App\Http\Controllers\Quizzes\QuizzController;
use App\Http\Controllers\Sections\SectionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Students\AttendanceController;
use App\Http\Controllers\Students\FeeController;
use App\Http\Controllers\Students\FeesInvoicesController;
use App\Http\Controllers\Students\GraduatedController;
use App\Http\Controllers\Students\LibraryController;
use App\Http\Controllers\Students\PormotionsController;
use App\Http\Controllers\Students\ProcessingFeeController;
use App\Http\Controllers\Students\ReceiptStudentsController;
use App\Http\Controllers\Students\StudentController;
use App\Http\Controllers\Subjects\SubjectController;
use App\Http\Controllers\Teacher\TeacherController;
use App\Livewire\Counter;
use App\Models\Fee_invoice;
use App\Models\ReceiptStudent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
















// Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('selection')->middleware('guest');
Route::get('/login/{type}',[LoginController::class,'loginForm'])->middleware('guest')->name('login.show');
Route::match(['get','post'],'/login',[LoginController::class ,'login'])->name('login');
Route::post('/logout/{type}', [LoginController::class ,'logout'])->name('logout');








Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ 
   Route::get('/dashboard', [HomeController::class,'dashboard'])->name('dashboard');
    Route::resource('Grades',GradesController::class);
    Route::resource('Classrooms',ClassroomController::class);
    Route::resource('Sections',SectionController::class);
    Route::post('delete_all',[ClassroomController::class,'delete_all'])->name('delete_all');
    Route::resource('Teachers',TeacherController::class);
    Route::View('/add_parent', 'livewire.Form')->name('add_parent');
    Livewire::setUpdateRoute(function ($handle) {
        return Route::post('/custom/livewire/update', $handle);
    });
    Route::resource("Students",StudentController::class);
    Route::get('/Get_classrooms/{id}',[StudentController::class,'Get_classrooms']);
    Route::get('/Get_Sections/{id}',[StudentController::class,'Get_Sections']);
    Route::get('/Get_amount/{id}',[FeeController::class,'Get_amount']);
    Route::post('/Upload',[StudentController::class,'Upload_attachment'])->name('Upload_attachment');
    Route::get('/Download_attachment/{student_name}/{filename}',[StudentController::class,'Download_attachment']);
    Route::post('delete',[StudentController::class,'Delete_attachment'])->name('Delete_attachment');
    Route::resource('Promotion',PormotionsController::class);
    Route::resource('Graduated',GraduatedController::class);
    Route::resource('Fees',FeeController::class);
    Route::resource('Fees_Invoices',FeesInvoicesController::class);
    Route::resource('receipt_students',ReceiptStudentsController::class);
    Route::resource('ProcessingFee', ProcessingFeeController::class);
    Route::resource('Attendance', AttendanceController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('Quizzes', QuizzController::class);
    Route::resource('questions', QuestionController::class);
    Route::resource('library', LibraryController::class);

     Route::resource('settings', SettingController::class);
    
    
    
    

    });


