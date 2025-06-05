<?php 

namespace App\Repository;

use App\Models\Fee;
use App\Models\Fee_invoice;
use App\Models\Grade;
use App\Models\Student;
use App\Models\StudentAccount;
use Illuminate\Support\Facades\DB;

class FeeInvoicesRepository implements FeeInvoicesRepositoryInterface
{
    public function index()
    {
        $Fee_invoices = Fee_invoice::all();
        $Grades = Grade::all();
        return view('Fees_Invoices.index',compact('Fee_invoices','Grades'));
    }

    public function show($id)
    {
        $student = Student::findorfail($id);
        
        $fees = Fee::where('Grade_id',$student->Grade_id)->where('Classroom_id',$student->Classroom_id)->where('year',$student->academic_year)->get();
        return view('Fees_Invoices.add',compact('student','fees'));
    }

    public function store($request)
    {
        foreach ($request->fee_id as $feeId) {
                $fee = Fee::findOrFail($feeId);
                $Fees = new Fee_invoice();
                $Fees->invoice_date = date('Y-m-d');
                $Fees->student_id = $request->student_id;
                $Fees->Grade_id = $request->Grade_id;
                $Fees->Classroom_id = $request->Classroom_id;;
                $Fees->fee_id = $feeId;
                $Fees->amount =$fee->amount;
                $Fees->description = $request->description;
                $Fees->save();

               $StudentAccount = new StudentAccount();
                $StudentAccount->type = 'invoice';
                $StudentAccount->date = date('Y-m-d');
                $StudentAccount->student_id = $request->student_id;
                $StudentAccount->Debit = $fee->amount;
                $StudentAccount->credit = 0.00;
                $StudentAccount->description = $request->description;
                $StudentAccount->save();
        }
         
       

            

            toastr()->success(trans('messages.success'));
            return redirect()->route('Fees_Invoices.index');
        
    }





      public function update($request)
    {
        DB::beginTransaction();
        try {
            // تعديل البيانات في جدول فواتير الرسوم الدراسية
            $Fees = Fee_invoice::findorfail($request->id);
            $Fees->fee_id = $request->fee_id;
            $Fees->amount = $request->amount;
            $Fees->description = $request->description;
            $Fees->save();

            // تعديل البيانات في جدول حسابات الطلاب
            $StudentAccount = StudentAccount::where('fee_invoice_id',$request->id)->first();
            $StudentAccount->Debit = $request->amount;
            $StudentAccount->description = $request->description;
            $StudentAccount->save();
            DB::commit();

            toastr()->success(trans('messages.Update'));
            return redirect()->route('Fees_Invoices.index');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        
            
            $data =  Fee_invoice::findOrFail($request->id);
            $st_inv = StudentAccount::where('student_id',$data->student_id)->first();
            $new_amount = ($st_inv->Debit - $data->amount);
            if ($new_amount == 0) {
                
                $st_inv->delete();
                
            }else
            {
                $st_inv->Debit = $new_amount;
                $st_inv->save();

            }
            $data->delete();

            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
       
    }

    public function edit($id)
    {
        $fee_invoices = Fee_invoice::findorfail($id);
        $fees = Fee::where('Grade_id',$fee_invoices->student->Grade_id)->where('Classroom_id',$fee_invoices->student->Classroom_id)->where('year',$fee_invoices->student->academic_year)->get();
        return view('Fees_Invoices.edit',compact('fee_invoices','fees'));
    }

}