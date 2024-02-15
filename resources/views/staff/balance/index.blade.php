@extends('staff/layout')
@section('title', 'Balance')

@section('content')
            <!-- Session Messages Starts -->
            @if(Session::has('success'))
            <div class="p-3 mb-2 bg-success text-white">
                <p>{{ session('success') }} </p>
            </div>
            @endif
            @if(Session::has('danger'))
            <div class="p-3 mb-2 bg-danger text-white">
                <p>{{ session('danger') }} </p>
            </div>
            @endif
            <!-- Session Messages Ends -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Balances</h3>
            <a href="#deductBalanceModal" data-toggle="modal" data-target="#deductBalanceModal" class="float-right btn btn-warning btn-sm" >Deduct Fixed Cost</a> 
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Balance</th>
                            <th>Last Transaction Date</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Balance</th>
                            <th>Last Transaction Date</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($data)
                        @foreach ($data as $key => $d)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>
                                @if ($d->students != null)
                                {{ $d->students->name }} - {{ $d->students->rollno }} - 
                                @if ($d->students->ms==1)
                                (Masters)
                                @else
                                (Honours)
                                @endif
                                @else
                                User Deleted
                                @endif
                            </td>
                            @if ($d->balance_amount<0)
                            <td class="bg-danger text-white">
                            @else
                            <td class="bg-success text-white">
                            @endif
                            {{ $d->balance_amount }}</td>
                            <td>
                                @if ($d->updated_at!=$d->created_at)
                                {{ $d->updated_at->format('F j, Y')  }}
                                @else
                                No Transaction Yet
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
 {{-- Deduct Balance Confirmation --}}
 <div class="modal fade" id="deductBalanceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
 aria-hidden="true">
 <div class="modal-dialog" role="document">
     <div class="modal-content">
         <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel">Are You Sure?</h5>
             <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">×</span>
             </button>
         </div>
         <div class="modal-body">Are You Sure You Want To Deduct Balance for Fixed Cost?</div>
         <div class="modal-footer">
             <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
             <a class="btn btn-danger" href="{{ route('staff.student.deductBalance') }}">Deduct Balance</a>
         </div>
     </div>
 </div>
 </div>
 {{-- Deduct Balance Confirmation --}}
    @section('scripts')
    @endsection
@endsection

