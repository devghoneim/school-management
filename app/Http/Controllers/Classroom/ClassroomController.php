<?php

namespace App\Http\Controllers\Classroom;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Grade;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Classes = Classroom::all();
        $Grades = Grade::all();
        return view('classes.index',compact('Grades','Classes'));
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

        $List_Classes = $request->List_Classes;

        foreach ($List_Classes as $List_Class) {
            
            $My_Classes = new Classroom();

            $My_Classes->Name_class = ['en' => $List_Class['Name_class_en'], 'ar' => $List_Class['Name']];

            $My_Classes->grade_id = $List_Class['Grade_id'];

            $My_Classes->save();
           
        }
        toastr()->success(trans('messages.success'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classroom $classroom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom)
    {
        dd($request);
        $Classrooms = Classroom::findOrFail($request->id);

        $Classrooms->update([

            $Classrooms->Name_Class = ['ar' => $request->Name, 'en' => $request->Name_en],
            $Classrooms->Grade_id = $request->Grade_id,
        ]);
        toastr()->success(trans('messages.Update'));
        return redirect()->route('Classrooms.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($classroom)
    {
        Classroom::findOrFail($classroom)->delete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Classrooms.index');
    }

    public function delete_all(Request $request)
    {
        $delete_all_id = explode(",", $request->delete_all_id);

        
        Classroom::whereIn('id', $delete_all_id)->Delete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Classrooms.index');

    }
}
