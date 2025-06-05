<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Repository\ReceiptStudentsRepository;
use Illuminate\Http\Request;

class ReceiptStudentsController extends Controller
{


    protected $Receipt;

    public function __construct(ReceiptStudentsRepository $Receipt)
    {
        
        $this->Receipt = $Receipt;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->Receipt->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
                return $this->Receipt->store($request);

    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
    return $this->Receipt->show($id);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
                return $this->Receipt->edit($id);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
                return $this->Receipt->update($request);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $id)
    {
                return $this->Receipt->destroy($id);

    }
}
