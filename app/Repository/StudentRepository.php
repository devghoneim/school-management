<?php

namespace App\Repository;

use App\Models\Classroom;
use App\Models\Gender;
use App\Models\Grade;
use App\Models\Image;
use App\Models\My_Parent;
use App\Models\Nationalitie;
use App\Models\Section;
use App\Models\Student;
use App\Models\Type_Bloods;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentRepository implements StudentRepositoryInterface
{
    public function CreateStudent()
    {
        $data['my_classes'] = Grade::all();
        $data['parents'] = My_Parent::all();
        $data['Genders'] = Gender::all();
        $data['nationals'] = Nationalitie::all();
        $data['bloods'] = Type_Bloods::all();
        return view('Students.create',$data);
    }
    
    public function Get_classrooms($id){

        
        $list_classes = Classroom::where("grade_id", $id)->pluck("Name_class", "id");

        return $list_classes;

    }

    //Get Sections
    public function Get_Sections($id){

        $list_sections = Section::where("Class_id", $id)->pluck("Name_Section", "id");
        return $list_sections;
    }

    public function Store_Student($request){

            $students = new Student();
            $students->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $students->email = $request->email;
            $students->password = Hash::make($request->password);
            $students->gender_id = $request->gender_id;
            $students->nationalitie_id = $request->nationalitie_id;
            $students->blood_id = $request->blood_id;
            $students->Date_Birth = $request->Date_Birth;
            $students->Grade_id = $request->Grade_id;
            $students->Classroom_id = $request->Classroom_id;
            $students->section_id = $request->section_id;
            $students->parent_id = $request->parent_id;
            $students->academic_year = $request->academic_year;
            $students->save();

            if($request->hasfile('photos'))
            {
                foreach($request->file('photos') as $file)
                {
                    $name = $file->getClientOriginalName();
                    $file->storeAs('attachments/students/'.$students->name,$name,'upload_attachments');
                    $students->images()->create(['filename'=>$name]);
                }
            }
            
            toastr()->success(trans('messages.success'));
            return redirect()->route('Students.create');
            
        

       

    }

    public function Get_Student()
    {
        $students = Student::all();
        return view('Students.index',compact('students'));
    }

    public function Edit_Student($id)
    {
        $Students = Student::findOrFail($id);
        $data['Grades'] = Grade::all();
        $data['parents'] = My_Parent::all();
        $data['Genders'] = Gender::all();
        $data['nationals'] = Nationalitie::all();
        $data['bloods'] = Type_Bloods::all();
        return view('Students.edit',$data,compact('Students'));

    }
    public function Update_Student($request)
    {
        $Edit_Students = Student::findorfail($request->id);
        $Edit_Students->name = ['ar' => $request->name_ar, 'en' => $request->name_en];
        $Edit_Students->email = $request->email;
        if (!empty($request->password)) {
            $Edit_Students->password = Hash::make($request->password);
        }
        $Edit_Students->gender_id = $request->gender_id;
        $Edit_Students->nationalitie_id = $request->nationalitie_id;
        $Edit_Students->blood_id = $request->blood_id;
        $Edit_Students->Date_Birth = $request->Date_Birth;
        $Edit_Students->Grade_id = $request->Grade_id;
        $Edit_Students->Classroom_id = $request->Classroom_id;
        $Edit_Students->section_id = $request->section_id;
        $Edit_Students->parent_id = $request->parent_id;
        $Edit_Students->academic_year = $request->academic_year;
        $Edit_Students->save();
        toastr()->success(trans('messages.Update'));
        return redirect()->route('Students.index');
    }

    public function Delete_Student($request)
    {

        Student::destroy($request->id);
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Students.index');
    }


    public function Show_student($id)
    {
        $Student = Student::findOrFail($id);
        return view('Students.show',compact('Student'));
    }

    public function  Upload_attachment($request)
    {
        if ($request->hasfile('photos')) {
            
            foreach($request->file('photos') as $file)
            {
                $name = $file->getClientOriginalName();
                $file->storeAs('attachments/students/'. $request->student_name,$name,'upload_attachments');

                $image = New Image();
                $image->filename = $name;
                $image->imageable_id = $request->student_id;
                $image->imageable_type = 'App\Models\Student';
                $image->save();
            }
        }


        toastr()->success(trans('messages.Update'));
        return redirect()->back();
    }

    public function Download_attachment($studen_name,$filename)
    {
        return response()->download(public_path('attachments/students/'.$studen_name . '/'.$filename));
    }

    public function Delete_attachment( $request)
    {
        Storage::disk('upload_attachments')->delete('attachments/students/'.$request->student_name.'/'.$request->filename);
        Image::where('id',$request->id)->where('filename',$request->filename)->delete();
        toastr()->success(trans('messages.Delete'));
        return redirect()->back();
    }
}