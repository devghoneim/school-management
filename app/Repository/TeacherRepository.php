<?php

namespace App\Repository;

use App\Models\Gender;
use App\Models\Specialization;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;


class TeacherRepository implements TeacherRepositoryInterface{


    public function getAll()
    {
        return Teacher::all();
    }


    public function getGender()
    {
       return Gender::all();
    }



    public function getSpecialization()
    {
      return Specialization::all();
    }

    public function store($request)
    {

       $Teachers = new Teacher();
       $Teachers->email = $request->Email;
       $Teachers->password =  Hash::make($request->Password);
       $Teachers->Name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
       $Teachers->Specialization_id = $request->Specialization_id;
       $Teachers->Gender_id = $request->Gender_id;
       $Teachers->Joining_Date = $request->Joining_Date;
       $Teachers->Address = $request->Address;
       $Teachers->save();
       toastr()->success(trans('messages.success'));
       return redirect()->route('Teachers.create');

    }


    public function edit($id)
    {

     return Teacher::findOrFail($id);

    }

    public function update($request)
    {
      $Teacher = Teacher::findOrFail($request->id);
      $Teacher->Email=$request->Email;
      $Teacher->name = ['en'=>$request->Name_en , 'ar'=>$request->Name_ar];
      $Teacher->Specialization_id = $request->Specialization_id;
      $Teacher->Gender_id = $request->Gender_id;
      $Teacher->Joining_Date = $request->Joining_Date;
      $Teacher->Address=$request->Address;
      if(!empty($request->Password))
      {
        $Teacher->Password =bcrypt($request->Password);
      }
      $Teacher->save();
      toastr()->success(trans('messages.Update'));
            return redirect()->route('Teachers.index');

    }

    public function delete($id)
    {
      Teacher::findOrFail($id)->delete();
      toastr()->error(trans('messages.Delete'));
      return redirect()->route('Teachers.index');
    }
}