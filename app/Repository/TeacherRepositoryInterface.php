<?php

namespace App\Repository;

interface TeacherRepositoryInterface{
    public function getAll();
    public function getGender();
    public function getSpecialization();
    public function store($request);
    public function edit($id);
    public function update($request);
    public function delete($id);

        
    
}