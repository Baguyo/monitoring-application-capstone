@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid py-3 px-3">

        @pageHeader
            ADMIN | Student
        @endpageHeader
        
        <hr>
        

        
        <a href="{{ route('admin.student.create') }}" class="btn btn-primary mb-3">Add Student</a>

        
        {{-- <div class="visible-print text-center">
            <img src="{{ Storage::url($qr_code->path) }}" alt="">
        </div> --}}

        <div class="card">
            
            <div class="card-body shadow">
                <div class="table-responsive mt-4">
                    <h5>List of Students</h5>
                    <table class="table table-hover table-bordered" id="student" style="font-size: 13px">
                        <thead>
                            <tr>
                                
                                <th>QR code</th>    
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Student Number</th>
                                {{-- <th>Guardian</th>
                                <th>Address</th> --}}
                                <th>Contact Number</th>
                                {{-- <th>Strand</th>
                                <th>Year</th>
                                <th>Section</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                            @forelse ($students as $item)

                                <tr>
                                        <td> 
                                             <img src="{{ Storage::url($item->qr_code_path) }}" alt="" height="64">

                                             <form action="{{ route('admin.student.qr_code', ['path'=>$item->qr_code_id]) }}" method="post">
                                                @csrf
                                                <button type="submit">Download</button>
                                             </form>
                                         </td>
                                        <td> <img src=" {{ ($item->user_image) ? Storage::url($item->user_image) :Storage::url('defaults/logo.png') }} " 
                                            alt="" height="100" width="100"> 
                                        </td>
                                        <td> {{ $item->users_name }} </td>
                                        <td> {{ $item->users_email }} </td>
                                        <td> {{ $item->student_number }} </td>
                                        {{-- <td> {{ $item->student_guardian }} </td>
                                        <td> {{ $item->student_address }} </td> --}}
                                        <td> {{ $item->student_contact_number }} </td>
                                        {{-- <td> {{ $item->strand_name }} </td>
                                        <td> {{ $item->year_level }} </td>
                                        <td> {{ $item->section_name }} </td> --}}

                                        {{-- BUTTONS --}}
                                        <td>
                                            
                                            <div class="">
                                                <a href="{{ route('admin.student.edit', ['student'=>$item->student_id]) }}" class="btn btn-sm btn-primary"> <i class="fas fa-pen-fancy"></i> </a>
                                            </div>
                                            
                                        </td>

                                </tr>

                            @empty
                                
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        

    </div>

    
    <script type="module">

        $(document).ready(function () {

            $('#student').DataTable(
                {
                    "order": [ 2, 'asc'],
                }
            );

            $('.dl-btn').click(function (e) { 
                e.preventDefault();
                this.parentNode.submit();
            });
        
           

        });

        

        

    </script>

@endsection
