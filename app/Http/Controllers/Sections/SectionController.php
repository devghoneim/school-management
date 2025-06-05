<?php

namespace App\Http\Controllers\Sections;

use \Log;
use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Grades = Grade::with('Sections.ClassRoom')->get(); 
        $list_Grades = Grade::all();
        $teachers = Teacher::all();
        return view('sections.sections',compact('list_Grades','Grades','teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Name_Section_Ar'=>['required','string'],
            'Name_Section_En'=>['required','string'],
            'Grade_id'=>['required','exists:grades,id'],
            'Class_id'=>['required','exists:classrooms,id']
        ]);
       $Section = Section::create([
            'Name_Section'=>['en'=>$request->Name_Section_En,'ar'=>$request->Name_Section_Ar],
            'Grade_id'=>$request->Grade_id,
            'Class_id'=>$request->Class_id,
            'Status'=>1
        ]);
        $Section->teachers()->sync($request->teacher_id);

        toastr()->success(trans('messages.success'));

         return redirect()->route('Sections.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $list_classes = Classroom::where("grade_id", $id)->pluck("Name_class", "id");

        return $list_classes;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        
        
        $section = Section::findOrFail($request->id);
            
        $request->validate([
            'Name_Section_Ar'=>['required','string'],
            'Name_Section_En'=>['required','string'],
            'Grade_id'=>['required','exists:grades,id'],
            'Class_id'=>['required','exists:classrooms,id'],
            'teacher_id' => ['sometimes', 'array'], 
            'teacher_id.*' => ['exists:teachers,id']
            
            
        ]);
        $section->Name_Section = ['en'=>$request->Name_Section_En,'ar'=>$request->Name_Section_Ar];
        $section->Grade_id=$request->Grade_id;
        $section->Class_id=$request->Class_id;
        if(isset($request->Status)) {
            $section->Status = 1;
          } else {
            $section->Status = 2;
          }
          $section->teachers()->detach();
          $section->teachers()->sync($request->teacher_id);
          $section->save();





            

          toastr()->success(trans('messages.Update'));
    
          return redirect()->route('Sections.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $id)
    {
        Section::findOrFail($id->id)->delete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Sections.index');
    
    }
}
