<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Repository\ProcessingFeeRepositoryInterface;
use Illuminate\Http\Request;

class ProcessingFeeController extends Controller
{
   
    protected $Processing ;

    public function __construct(ProcessingFeeRepositoryInterface $Processing)
    {
        return $this->Processing = $Processing;
    }

    public function index()
    {
      return $this->Processing->index();

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
                return $this->Processing->store($request);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
                return $this->Processing->show($id);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
                return $this->Processing->edit($id);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
                return $this->Processing->update($request);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
                return $this->Processing->destroy($request);

    }
}
