<?php

namespace App\Repository;

use App\Models\Grade;
use App\Models\Promotion;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentsPormotions implements StudentsPormotionsInterface
{


    public function index()
    {

      $Grades = Grade::all();
      return  view('Students.pormotion.index',compact('Grades'));
    }
    public function store($request)
    {

       
    
            $students = Student::where('Grade_id', $request->Grade_id)->where('Classroom_id', $request->Classroom_id)->where('section_id', $request->section_id)->where('academic_year',$request->academic_year)->get();
                
            if ($students->isEmpty()) {
                return redirect()->back()->with('error_promotions', __('لاتوجد بيانات في جدول الطلاب'));
            }
    
            
            $studentIds = $students->pluck('id');
            Student::whereIn('id', $studentIds)->update([
                'Grade_id' => $request->Grade_id_new,
                'Classroom_id' => $request->Classroom_id_new,
                'section_id' => $request->section_id_new,
                'academic_year'=>$request->academic_year_new
            ]);
    
            // Insert into promotions
            foreach ($students as $student) {
              Promotion::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'from_grade' => $request->Grade_id,
                        'from_Classroom' => $request->Classroom_id,
                        'from_section' => $request->section_id,
                        'to_grade' => $request->Grade_id_new,
                        'to_Classroom' => $request->Classroom_id_new,
                        'to_section' => $request->section_id_new,
                        'academic_year'=>$request->academic_year,
                        'academic_year_new'=>$request->academic_year_new
                    ]
                );
            }
    
          
            toastr()->success(trans('messages.success'));
            return redirect()->back();
    
        
    }
    
    public function create()
    {
        $promotions = Promotion::all();
        return view('Students.pormotion.management',compact('promotions'));
    }


    public function destroy($request)
    {

        if ($request->page_id == 1) {
            $promtions = Promotion::all();

            foreach ($promtions as $Promotion) {
                
                Student::where('id',$Promotion->student_id)->update([
                    'Grade_id'=>$Promotion->from_grade,
                 'Classroom_id'=>$Promotion->from_classroom,
                 'section_id'=> $Promotion->from_section,
                 'academic_year'=>$Promotion->academic_year,
                ]);


            }
            Promotion::truncate();

        }else
        {
            $Promotion = Promotion::findOrFail($request->id);
            Student::where('id',$Promotion->student->id)->update([
                'Grade_id'=>$Promotion->from_grade,
                'Classroom_id'=>$Promotion->from_classroom,
                'section_id'=> $Promotion->from_section,
                'academic_year'=>$Promotion->academic_year,
            ]);
            $Promotion->delete();
        }

       
        toastr()->error(trans('messages.Delete'));
            return redirect()->back();




    }

}
