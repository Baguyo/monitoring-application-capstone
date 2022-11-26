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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Guardian</th>
                                <th>Address</th>
                                <th>Contact Number</th>
                                <th>Strand</th>
                                <th>Year</th>
                                <th>Section</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                            @forelse ($students as $item)

                                <tr>
                                   
                                    @if ($item->student_deleted)
                                        
                                        <td> 
                                            <img src="{{ Storage::url($item->qr_code_path) }}" alt="" height="68">
                                            <form action="{{ route('admin.student.qr_code', ['path'=>$item->qr_code_id]) }}" method="post">
                                                @csrf
                                                <button type="submit">Download</button>
                                             </form>
                                        </td>
                                        <td> <del>{{ $item->users_name }}       </del></td>
                                        <td> <del>{{ $item->users_email }}      </del></td>
                                        <td> <del>{{ $item->student_guardian }} </del></td>
                                        <td> <del>{{ $item->student_address }}  </del></td>
                                        <td> <del>{{ $item->student_contact_number }} </del></td>
                                        <td> <del>{{ $item->strand_name }} </del></td>
                                        <td> <del>{{ $item->year_level }}   </del></td>
                                        <td> <del>{{ $item->section_name }} </del></td>

                                        {{-- BUTTONS --}}
                                        <td class="">
                                            
                                            <div class="d-flex">
                                                <form action="{{ route('admin.student.restore', ['student'=>$item->student_id]) }}" method="POST" class=" restore mr-2">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fas fa-recycle"></i>
                                                    </button>
                                                </form>
                                                    
                                                <form action="{{ route('admin.student.forceDelete', ['student'=>$item->student_id]) }}" method="post" class=" f-delete" >
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            
                                            
                                        </td>
                                        
                                    @else
                                        
                                        <td> 
                                             <img src="{{ Storage::url($item->qr_code_path) }}" alt="" height="64">

                                             <form action="{{ route('admin.student.qr_code', ['path'=>$item->qr_code_id]) }}" method="post">
                                                @csrf
                                                <button type="submit">Download</button>
                                             </form>
                                         </td>
                                        <td> {{ $item->users_name }} </td>
                                        <td> {{ $item->users_email }} </td>
                                        
                                        <td> {{ $item->student_guardian }} </td>
                                        <td> {{ $item->student_address }} </td>
                                        <td> {{ $item->student_contact_number }} </td>
                                        <td> {{ $item->strand_name }} </td>
                                        <td> {{ $item->year_level }} </td>
                                        <td> {{ $item->section_name }} </td>

                                        {{-- BUTTONS --}}
                                        <td>
                                            
                                            <div class="d-flex">
                                                <a href="{{ route('admin.student.edit', ['student'=>$item->student_id]) }}" class="btn btn-sm btn-primary mr-2"> <i class="fas fa-pen-fancy"></i> </a>
                                                
                                                <form action="{{ route('admin.student.destroy', ['student'=>$item->student_id]) }}" method="post" class="delete" >
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            
                                            
                                        </td>
                                    @endif

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
                    "order": [ 7, 'asc'],
                    
                    // columnDefs: [
                    //     {
                    //         target: 0,
                    //         visible: false,
                    //         searchable: false,
                    //     },
                    // ],
                }
            );

            $('.dl-btn').click(function (e) { 
                e.preventDefault();
                this.parentNode.submit();
            });
        
           

        });

        

        

    </script>

@endsection
