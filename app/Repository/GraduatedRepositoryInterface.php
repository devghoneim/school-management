<?php 
namespace App\Repository;
interface GraduatedRepositoryInterface
{
    public function index();

    public function create();

    // update Students to SoftDelete
    public function SoftDelete($request);

    // ReturnData Students
    public function ReturnData($request);

    // destroy Students
    public function destroy($request);
}