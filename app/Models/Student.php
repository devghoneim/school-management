<?php

namespace App\Models;

use App\Models\Classroom;
use App\Models\Gender;
use App\Models\Grade;
use App\Models\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Illuminate\Foundation\Auth\User as Authenticatable; 


class Student extends Authenticatable
{
    use SoftDeletes;
    use HasTranslations;
    public $translatable = ['name'];
    protected $guarded =[];

    public function gender()
    {
        return $this->belongsTo(Gender::class,'gender_id');
    }
    public function grade()
    {
        return $this->belongsTo(Grade::class,'Grade_id');
    }
    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'Classroom_id');
    }

    // علاقة بين الطلاب الاقسام الدراسية لجلب اسم القسم  في جدول الطلاب

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function images()
    {
        return $this->morphMany(Image::class,'imageable');
    }
    public function Nationality()
    {
        return $this->belongsTo(Nationalitie::class, 'nationalitie_id');
    }
    public function myparent()
    {
        return $this->belongsTo(My_Parent::class, 'parent_id');
    }

      public function student_account()
    {
        return $this->hasMany('App\Models\StudentAccount', 'student_id');

    }
    public function attendance()
    {
                return $this->hasMany('App\Models\Attendance', 'student_id');

    }
}
