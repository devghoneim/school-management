<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Repository\StudentsPormotionsInterface;
use Illuminate\Http\Request;

class PormotionsController extends Controller
{
    
    protected $promotion;


    public function __construct(StudentsPormotionsInterface $promotion)
    {
          $this->promotion = $promotion;
    }

    public function index()
    {
        return $this->promotion->index();
    }   

        /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->promotion->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->promotion->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        
        
            return $this->promotion->destroy($request);
        


    }
}
