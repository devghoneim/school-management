<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeacher;
use App\Http\Requests\UpdateTeacher;
use App\Repository\TeacherRepositoryInterface;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    protected $Teacher;

    public function __construct(TeacherRepositoryInterface $Teacher )
    {
        $this->Teacher = $Teacher;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Teachers = $this->Teacher->getAll();
        return view('Teachers.index',compact('Teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genders = $this->Teacher->getGender();
        $specializations = $this->Teacher->getSpecialization();
        return view('Teachers.create',compact('genders','specializations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeacher $request)
    {
        return $this->Teacher->store($request);
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
    public function edit($id)
    {

        $Teachers = $this->Teacher->edit($id);
        $specializations=$this->Teacher->getSpecialization();
        $genders=$this->Teacher->getGender();

        return view('Teachers.edit',compact('Teachers','specializations','genders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeacher $request)
    {

        return $this->Teacher->update($request);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $id)
    {
        
        return $this->Teacher->delete($id->id);
    }
}
