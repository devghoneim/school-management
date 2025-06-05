<?php
namespace App\Repository;
Interface StudentsPormotionsInterface
{

    public function index();
    public function store($request);
    public function create();
    public function destroy($request);



}