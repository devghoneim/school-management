<?php

namespace App\Models;

use App\Models\Grade;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;


class Classroom extends Model
{
    
    use HasTranslations;

    public $translatable = ['Name_class']; 
    protected $guarded=[];

    public function grade()
{
    
    return $this->belongsTo(Grade::class, 'grade_id');
}

}
