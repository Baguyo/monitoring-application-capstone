@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-3">

        @pageHeader
            ADMIN | Section
        @endpageHeader
        
        <hr>

        <a href="{{ route('admin.section.create') }}" class="btn btn-primary my-3">Add section</a>

        <div class="card">
            <div class="card-body shadow">
                <div class="table-responsive-lg mt-4">
                    <h5>List of Sections</h5>

                        

                        <table class="table table-hover table-bordered" id="section-table">
                            <thead>
                                <tr>
                                    
                                    <th>Name</th>
                                    <th>Grade level</th>
                                    <th>Date creation</th>
                                    <th>Date updation</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($all_sections as $item)
                                    <tr>

                                        @if ($item->trashed())

                                            <td> <del>{{ $item->name }} </del></td>
                                            <td> <del>{{ $item->yearLevel->level }} </del> </td>
                                            <td> <del>{{ $item->created_at }} </del> </td>
                                            <td> <del>{{ $item->updated_at }} </del></td>
                                            <td>
                                                
                                                <form action="{{ route('admin.section.restore', ['section'=>$item->id]) }}" method="POST" class="d-inline hidden restore">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-recycle"></i>
                                                    </button>
                                                </form>
                                                    /
                                                <form action="{{ route('admin.section.forceDelete', ['section'=>$item->id]) }}" method="post" class="d-inline f-delete" >
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                </form>
                                            </td>

                                        @else

                                            
                                            <td> {{ $item->name }} </td>
                                            <td> {{ $item->yearLevel->level }} </td>
                                            <td> {{ $item->created_at }} </td>
                                            <td> {{ $item->updated_at }} </td>
                                            <td>
                                                
                                                <a href="{{ route('admin.section.edit', ['section'=>$item->id]) }}" class="btn btn-primary"> <i class="fas fa-pen-fancy"></i> </a>
                                                    /
                                                    <form action="{{ route('admin.section.destroy', ['section'=>$item->id]) }}" method="post" class="d-inline delete" >
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                            </td>
                                        
                                        @endif

                                        {{-- <td> {{ $item->name }} </td>
                                        <td> {{ $item->yearLevel->level }} </td>
                                        <td> {{ $item->created_at }} </td>
                                        <td> {{ $item->updated_at }} </td>
                                        <td>
                                            
                                            <a href="{{ route('admin.section.edit', ['section'=>$item->id]) }}" class="btn btn-primary"> <i class="fas fa-pen-fancy"></i> </a>
                                                /
                                                <form action="{{ route('admin.section.destroy', ['section'=>$item->id]) }}" method="post" class="d-inline delete" >
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                        </td> --}}
                                    </tr>
                                @empty
                                    
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>

    </div>
    <script type="module">
         
        // var selectAll = $('.select-all');
        // var select = $('.select');

        // $(selectAll).change(function (e) { 
        //     if(selectAll.prop('checked')){    
        //         select.each(function (index, element) {
        //             this.checked = true;
                    
        //         });
        //     }else{
        //         select.each(function (index, element) {
        //             this.checked = false; 
        //         });   
        //     }
            
        // });
        
      

    

        $('.delete').submit(function (e) { 
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to delele this record ?',
                text: " All data associated to this record will also be deleted ! ",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });

        $('.restore').submit(function (e) { 
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to restore this record ?',
                text: " All data associated to this record will also be restored ",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, restore it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });

        $('.f-delete').submit(function (e) { 
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to permanently delete this record ?',
                text: " All data associated to this record will also be deleted permanently ",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });

    </script>
@endsection