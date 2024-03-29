@extends('staff/layout')
@section('title', 'Student Search')

@section('content')


    <!-- Page Heading -->
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
            @if(Session::has('danger-email'))
            <div class="p-3 mb-2 bg-danger text-white">
                <h3>Allready Existed User's</h3>
                @foreach (session('danger-email') as $eemails)
                    <span class="m-1">
                        {{ $eemails }} ,
                    </span>
                     @endforeach
            </div>
            @endif
            <!-- Session Messages Ends -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Students Data
                
            <a href="{{ route('staff.student.create') }}" class="float-right btn btn-success btn-sm mx-1" target="_blank">Add New </a>  
            <a href="{{ route('staff.student.bulk') }}" class="float-right btn btn-info btn-sm mx-1" target="_blank">Add From CSV </a> 
            <div class="float-right mx-1">
                <form method="POST" class="form-control pb-1" action="{{ route('staff.student.search') }}">
                    @csrf
                    <label for="search-date"> Students : </label>
                    <select  name="type" id="">
                        <option @if ($type==2) selected @endif value="2">All</option>
                        <option @if ($type==1) selected @endif value="1">MS</option>
                        <option @if ($type==0) selected @endif value="0">Honours</option>
                    </select>
                    <button type="submit" class="btn btn-dark btn-sm mx-1" >Search</button>
                </form>
            </div>
        </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th>RollNo</th>
                            <th>Name</th>
                            <th>Room</th>
                            <th>Department</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th>RollNo</th>
                            <th>Name</th>
                            <th>Room</th>
                            <th>Department</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($data)
                        @foreach ($data as $key=> $d)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td><img width="100"
                                class=""
                                src="{{$d->photo ? asset('storage/'.$d->photo) : asset('images/user.png')}}"
                                alt=""
                            /></td>
                            <td>{{ $d->rollno }}
                            
                            </td>
                            <td>{{ $d->name }}</td>
                            <td>
                                @if ($d->allocatedRoom)
                                (Room No - {{ $d->allocatedRoom->rooms->title }})
                                   @else
                                   Not Allocated
                               @endif
                            </td>
                            <td>{{ $d->dept }}</td>
                            
                            
                            <td class="text-center">
                                <a href="{{ url('staff/student/'.$d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                <a href="{{ url('staff/student/'.$d->id.'/edit') }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                <a onclick="return confirm('Are You Sure?')" href="{{ url('staff/student/'.$d->id.'/delete') }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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

