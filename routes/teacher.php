<?php

use App\Http\Controllers\Teacher\dashboard\StudentController;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;







Route::group(
    [
        'prefix' => LaravelLocalization::setLocale() .'/teacher',
        'as'=>'teacher.',
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:teacher']
    ], function () {

    //==============================dashboard============================
    Route::get('dashboard', function () {
       $ids = Teacher::findorFail(auth('teacher')->user()->id)->Sections()->pluck('section_id');
        $data['count_sections']= $ids->count();
        $data['count_students']= Student::whereIn('section_id',$ids)->count();
        return view('Teachers.dashboard.dashboard',$data);
    })->name('dashboard');

    Route::resource('student',StudentController::class)->names('student');
     Route::get('sections',[StudentController::class,'sections'])->name('sections');
     Route::post('attendance',[StudentController::class,'attendance'])->name('attendance');
     Route::post('edit_attendance',[StudentController::class,'editAttendance'])->name('attendance.edit');
     Route::get('attendance_report',[StudentController::class, 'attendanceReport'])->name('attendance.report');
     Route::post('attendance_report',[StudentController::class, 'attendanceSearch'])->name('attendance.search');

});