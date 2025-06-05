<?php

namespace App\Models;

use App\Models\Classroom;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;


class Section extends Model
{
    use HasTranslations;
   
    public $translatable = ['Name_Section'];
   
    protected $guarded =[];







    public function ClassRoom()
    {
        return $this->belongsTo(Classroom::class,'Class_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class,'section_teacher');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class,'Grade_id');
    }
   



}
