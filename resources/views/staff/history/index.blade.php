@extends('staff/layout')
@section('title', 'History')

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
            <h3 class="m-0 font-weight-bold text-primary">History <a href="{{ route('staff.history.read') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-check"></i> Mark All As Read </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Staff</th>
                            <th>Details</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th width="20%">Staff</th>
                            <th>Details</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($data)
                        @foreach ($data as $key=> $d)
                        <tr @if ($d->status==0)
                            class="bg-info text-white"
                            @else
                        @endif >
                            <td>{{ ++$key }}</td>
                            <td>{{ $d->staff->name }}</td>
                            <td>{{ $d->data }}
                            <span
                            @switch($d->flag)
                                @case('add')
                                class="bg-success text-white p-1 m-1 rounded"
                                    @break
                                @case('delete')
                                    class="bg-danger text-white p-1 m-1 rounded"
                                        @break
                                @case('update')
                                        class="bg-primary text-white p-1 m-1 rounded "
                                            @break
                                @default
                                class="bg-warning text-white p-1 m-1 rounded text-capitalize"
                            @endswitch
                            >
                            @switch($d->flag)
                            @case('add')
                            Add
                                @break
                            @case('delete')
                                Delete
                                    @break
                            @case('update')
                                    Update
                                        @break
                            @default
                            {{ $d->flag }}
                        @endswitch</span>
                            </td>
                            <td>{{ $d->created_at->format("F j, Y") }}</td>
                            
                            <td class="text-center">
                                <a href="{{ route('staff.history.show',$d->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                            </td>

                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

