@extends('layouts.master')
@section('css')
@section('title')
    اضافة فاتورة جديدة
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    اضافة فاتورة جديدة {{ $student->name }}
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class=" row mb-30" action="{{ route('Fees_Invoices.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        
                            
                                    <div class="row">

                                        <div class="col">
                                            <label for="Name" class="mr-sm-2">اسم الطالب</label>
                                            <h4 for="Name" class="mr-sm-2">{{ $student->name }}</h4>
                                            {{-- <input disabled class="form-control" type="text" name="student_id" value="{{$student->name}}"> --}}


                                        </div>

                                        <div class="col">
                                            <label for="Name_en" class="mr-sm-2">نوع الرسوم</label>
                                            <div class="box">
                                                {{-- <select multiple class="fancyselect" name="fee_id[]" required>
                                                    <option selected disabled value="">-- اختار من القائمة --
                                                    </option>
                                                    @foreach ($fees as $fee)
                                                        <option value="{{ $fee->id }}">{{ $fee->title }}</option>
                                                    @endforeach
                                                </select> --}}
                                                <select multiple name="fee_id[]" class="form-control">
                                                    @foreach ($fees as $fee)
                                                        <option value="{{ $fee->id }}">{{ $fee->title }} = {{ $fee->amount }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>

                                        <div class="amount">
                                            {{-- <label for="Name_en" class="mr-sm-2">المبلغ</label>
                                                    <div class="box">
                                                        <select class="fancyselect" name="amount" required>
                                                            <option value="">-- اختار من القائمة --</option>
                                                            @foreach ($fees as $fee)
                                                                <option value="{{ $fee->amount }}">{{ $fee->amount }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div> --}}
                                            {{-- <input type="text" disabled value=""> --}}
                                        </div>

                                        <div class="col">
                                            <label for="description" class="mr-sm-2">البيان</label>
                                            <div class="box">
                                                <input type="text" class="form-control" name="description" required>
                                            </div>
                                        </div>

                                        {{-- <div class="col">
                                            <label for="Name_en"
                                                class="mr-sm-2">{{ trans('My_Classes_trans.Processes') }}:</label>
                                            <input class="btn btn-danger btn-block" data-repeater-delete type="button"
                                                value="{{ trans('My_Classes_trans.delete_row') }}" />
                                        </div> --}}
                                    </div>
                            










                            <div class="row mt-20 mx-5">
                                <button type="submit" class="btn btn-primary">تاكيد البيانات</button>
                            </div>
                            <br>
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                            <input type="hidden" name="Grade_id" value="{{ $student->Grade_id }}">
                            <input type="hidden" name="Classroom_id" value="{{ $student->Classroom_id }}">

                        
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')
<script>
    $(document).ready(function() {
        console.log("AJAX script loaded");

        $(document).on('change', 'select[name="fee_id"]', function() {
            var id_fee = $(this).val();
            console.log("fee_id changed:", id_fee);

            var $repeaterItem = $(this).closest('[data-repeater-item]');
            var $amountDiv = $repeaterItem.find('.amount');

            if (id_fee) {
                $.ajax({
                    url: "{{ url('Get_amount') }}/" + id_fee,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log("AJAX success:", data);
                        $amountDiv.empty();
                        $amountDiv.addClass('col');
                        $amountDiv.append(
                            '<label class="mr-sm-2">السعر</label>' +
                            '<input class="form-control" type="text" disabled value="' +
                            data + '">'
                        );
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX error:", error);
                    }
                });
            } else {
                $amountDiv.empty();
            }
        });
    });
</script>


@endsection
