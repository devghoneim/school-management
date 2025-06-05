<?php

namespace App\Http\Controllers\Grades;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $Grades = Grade::all();

        return view('grades.index',compact('Grades'));
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
        if (Grade::where('Name->ar',$request->Name)->orWhere('Name->en',$request->Name_en)->exists()) {
            return redirect()->back()->withErrors(trans('Grades_trans.exists'));
        }
        $request->validate([
            'Name' => 'required|string',
            'Name_en' => 'required|string',
            'Notes' => 'nullable|string',
        ],
    [
        'Name.required'=>trans('validation.required'),
        'Name_en.required'=>trans('validation.required'),
    ]
    );

        $grade = new Grade();
        $grade->Name = [
            'ar' => $request->Name,  
            'en' => $request->Name_en, 
        ];
        $grade->Notes = $request->Notes;
        $grade->save();
        toastr()->success(trans('messages.success'));
        return redirect()->route('Grades.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, $id)
    {
        $grade = Grade::findOrFail($id);
        
        $request->validate([
            'Name' => 'required|string',
            'Name_en' => 'required|string',
            'Notes' => 'nullable|string',
        ],
    [
        'Name.required'=>trans('validation.required'),
        'Name_en.required'=>trans('validation.required'),
    ]
    );

    $grade->update([
        'Name' => ['ar'=>$request->Name , 'en'=>$request->Name_en],
        'Notes'=>$request->Notes
    ]);
    
    toastr()->success(trans('messages.Update'));
    return redirect()->route('Grades.index');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $classroomes = Classroom::where('grade_id',$id);
        if ($classroomes->count() == 0) {
            Grade::findOrFail($id)->delete();
         toastr()->error(trans('messages.Delete'));
    }else
    {
        toastr()->error(trans('Grades_trans.delete_Grade_Error'));
    }
    return redirect()->route('Grades.index');   
}
}
