<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeesRequest;
use App\Models\Fee;
use App\Repository\FeeRepositoryInterface;
use Illuminate\Http\Request;

class FeeController extends Controller
{

    protected $Fees ;

    public function __construct(FeeRepositoryInterface $Fee)
    {
        $this->Fees = $Fee;
    }

    
        public function index()
    {
        return $this->Fees->index();
    }

    public function create()
    {
        return $this->Fees->create();
    }


    public function store(StoreFeesRequest $request)
    {
        return $this->Fees->store($request);
    }

    public function edit($id)
    {
        return $this->Fees->edit($id);
    }


    public function update(StoreFeesRequest $request)
    {
        return $this->Fees->update($request);
    }


    public function destroy(Request $request)
    {
        return $this->Fees->destroy($request);
    }
    
    public function Get_amount($id)
    {
       
        

        $amount = Fee::where('id',$id)->first();
        return $amount->amount;
        
    }
}
