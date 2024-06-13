@extends('staff/layout')
@section('title', 'Add New Student')
@section('content')


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary"> Add New Student
            <a href="{{ url('staff/student') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                   <p class="text-danger"> {{ $error }} </p>
                @endforeach
                @endif
            <form onsubmit="handleSubmit(event)"  method="POST" action="{{ route('staff.student.store') }}" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                    <tr>
                    <th>Roll No <span class="text-danger">*</span></th>
                    <td><input required name="rollno" type="text" class="form-control" value="{{ old('rollno')}}"></td>
                    </tr>
                    <tr>
                   <th>Full Name <span class="text-danger">*</span></th>
                        <td><input required name="name" type="text" class="form-control" value="{{ old('name')}}"></td>
                    </tr><tr>
                        <th>Department <span class="text-danger">*</span></th>
                        <td>
                            <select required name="dept" class="form-control">
                                <option selected value="0">Select Department</option>
                                <option value="Computer Science and Engineering(CSE)">Computer Science and Engineering(CSE)</option>
                                <option value="Electrical and Electronic Engineering(EEE)">Electrical and Electronic Engineering(EEE)
                                </option>
                                <option value="Industrial and Production Engineering(IPE)">Industrial and Production Engineering(IPE)
                                </option>
                                <option value="Petroleum and Mining Engineering(PME)">Petroleum and Mining Engineering(PME)</option>
                                <option value="Chemical Engineering(ChE)">Chemical Engineering(ChE)</option>
                                <option value="Biomedical Engineering(BE)">Biomedical Engineering(BE)</option>
                                <option value="Textile Engineering(TE)">Textile Engineering(TE)</option>
                                <option value="Agro Product Processing Technology">Agro Product Processing Technology</option>
                                <option value="Climate and Disaster Management">Climate and Disaster Management</option>
                                <option value="Environmental Science and Technology">Environmental Science and Technology</option>
                                <option value="Nutrition and Food Technology">Nutrition and Food Technology</option>
                                <option value="Fisheries and Marine Bioscience">Fisheries and Marine Bioscience</option>
                                <option value="Genetic Engineering and Biotechnology">Genetic Engineering and Biotechnology</option>
                                <option value="Microbiology">Microbiology</option>
                                <option value="Pharmacy">Pharmacy</option>
                                <option value="Nursing and Health Science">Nursing and Health Science</option>
                                <option value="Physical Education and Sports Science">Physical Education and Sports Science</option>
                                <option value="Physiotherapy and Rehabilitation">Physiotherapy and Rehabilitation</option>
                                <option value="English">English</option>
                                <option value="Chemistry">Chemistry</option>
                                <option value="Mathematics">Mathematics</option>
                                <option value="Physics">Physics</option>
                                <option value="Accounting and Information Systems">Accounting and Information Systems</option>
                                <option value="Finance and Banking">Finance and Banking</option>
                                <option value="Management">Management</option>
                                <option value="Marketing">Marketing</option>
                                <!-- Add more departments here -->
                            </select>    
                        </td>
                    </tr><tr>
                         <th>Session <span class="text-danger">*</span></th>
                        <td>
                            <select required name="session" class="form-control">
                                <option selected value="0"> -- Select Session -- </option>
                                <option value="2017-18">2017-18</option>
                                <option value="2018-19">2018-19</option>
                                <option value="2019-20">2019-20</option>
                                <option value="2020-21">2020-21</option>
                                <option value="2021-22">2021-22</option>
                                <option value="2022-23">2022-23</option>
                                <option value="2023-24">2023-24</option>
                                <option value="2024-25">2024-25</option>
                            </select>    
                        </td>
                    </tr><tr>
                        <th>Email <span class="text-danger">*</span></th>
                        <td><input required name="email" type="email" class="form-control" value="{{ old('email')}}"></td>
                    </tr><tr>
                        <th>Password <span class="text-danger">*</span></th>
                        <td><input required name="password" type="password" class="form-control" ></td>
                    </tr><tr>
                        <th>Mobile No <span class="text-danger">*</span></th>
                        <td><input required name="mobile" type="text" class="form-control" maxlength="11" value="{{ old('mobile')}}" pattern="[0-9]{11}"></td>
                    </tr>
                    <tr>
                        <th>Masters <span class="text-danger">*</span></th>
                        <td><select required name="ms" id="" required class="form-control">
                            <option value="1"> Yes </option>
                            <option value="0"> No </option>
                        </select></td>
                    </tr>
                    {{-- <tr>
                        <th>Gender <span class="text-danger">*</span></th>
                        <td><select required name="gender" class="form-control room-list">
                        <option value="3">--- Select Gender ---</option>
                        <option value="1"> Male </option>
                        <option value="0"> Female </option>
                    </select></td>
                    </tr> --}}
                    <tr>
                        <th>Photo</th>
                        <td><input name="photo" type="file" accept="image/*" ></td>
                    </tr><tr>
                        <th>Address</th>
                        <td><textarea name="address" class="form-control">{{ old('address')}}</textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

