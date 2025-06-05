<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class ProcessingFee extends Model
{
    protected $guarded=[];
     public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
