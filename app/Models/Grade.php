<?php

namespace App\Models;

use App\Models\Section;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Grade extends Model
{
    use HasTranslations;

    public $translatable = ['Name']; 


    protected $fillable = ['Name','Notes'];

    public function Sections()
    {
        return $this->hasMany(Section::class,'Grade_id');
    }

}
