<?php

namespace App\Models;

use App\Models\Section;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    use HasTranslations;

    protected $guarded=[];
    public $translatable=['Name'];





    public function genders()
    {
       return $this->belongsTo(Gender::class,'Gender_id');
    }

    public function specializations()
    {
        return $this->belongsTo(Specialization::class,'Specialization_id');
    }

    
    public function sections()
    {
        return $this->belongsToMany(Section::class,'section_teacher');
    }
}
