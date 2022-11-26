@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid py-3 px-3">

        @pageHeader
            ADMIN | Student
        @endpageHeader
        
        <hr>
        

        
        <a href="{{ route('admin.student.create') }}" class="btn btn-primary my-3">Add Student</a>



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
                                <th>Year</th>
                                <th>Section</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                            @forelse ($students as $item)

                                <tr>
                                   
                                    @if ($item->trashed())
                                        <td> 
                                            <img src="{{ Storage::url($item->qr_code->path) }}" alt="" height="68">
                                            <form action="{{ route('admin.student.qr_code', ['path'=>$item->qr_code->id]) }}" method="post">
                                                @csrf
                                                <a href="#" class="dl-btn">Download</a>
                                             </form>
                                        </td>
                                        <td> <del>{{ $item->user->name }} </del> </td>
                                        <td> <del>{{ $item->user->email }} </del> </td>
                                        <td> <del>{{ $item->guardian }} </del> </td>
                                        <td> <del>{{ $item->address }} </del> </td>
                                        <td> <del>{{ $item->contact_number }} </del> </td>
                                        <td> <del>{{ $item->section->yearLevel->level }} </del> </td>
                                        <td> <del>{{ $item->section->name }} </del> </td>

                                        {{-- BUTTONS --}}
                                        <td class="">
                                            
                                            <div class="d-flex">
                                                <form action="{{ route('admin.student.restore', ['student'=>$item->id]) }}" method="POST" class=" restore mr-2">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fas fa-recycle"></i>
                                                    </button>
                                                </form>
                                                    
                                                <form action="{{ route('admin.student.forceDelete', ['student'=>$item->id]) }}" method="post" class=" f-delete" >
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            
                                            
                                        </td>
                                        
                                    @else
                                        <td> 
                                             <img src="{{ Storage::url($item->qr_code->path) }}" alt="" height="64">

                                             <form action="{{ route('admin.student.qr_code', ['path'=>$item->qr_code->id]) }}" method="post">
                                                @csrf
                                                <a href="#" class="dl-btn">Download</a>
                                             </form>
                                         </td>
                                        <td> {{ $item->user->name }} </td>
                                        <td> {{ $item->user->email }} </td>
                                        <td> {{ $item->guardian }} </td>
                                        <td> {{ $item->address }} </td>
                                        <td> {{ $item->contact_number }} </td>
                                        <td> {{ $item->section->yearLevel->level }} </td>
                                        <td> {{ $item->section->name }} </td>

                                        {{-- BUTTONS --}}
                                        <td>
                                            
                                            <div class="d-flex">
                                                <a href="{{ route('admin.student.edit', ['student'=>$item->id]) }}" class="btn btn-sm btn-primary mr-2"> <i class="fas fa-pen-fancy"></i> </a>
                                                
                                                <form action="{{ route('admin.student.destroy', ['student'=>$item->id]) }}" method="post" class="delete" >
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

            $('#student').DataTable();

            $('.dl-btn').click(function (e) { 
                e.preventDefault();
                this.parentNode.submit();
            });
        
           
        });

        

        

    </script>

@endsection
