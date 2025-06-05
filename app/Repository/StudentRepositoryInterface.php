<?php
namespace App\Repository;

interface StudentRepositoryInterface {

public function CreateStudent();
public function Get_classrooms($id);
public function Get_Sections($id);
public function Store_Student($request);
public function Get_Student();
public function Edit_Student($id);
public function Delete_Student($request);
public function  Update_Student($request);
public function  Show_Student($id); 
public function  Upload_attachment($request);
public function Download_attachment($studen_name,$filename);
public function Delete_attachment( $request);


}