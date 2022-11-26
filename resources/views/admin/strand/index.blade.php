@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid py-3 px-3">

        @pageHeader
            ADMIN | Strands
        @endpageHeader
        
        

        
        <a href="{{ route('admin.strand.create') }}" class="btn btn-primary my-3">Add Strand</a>


        <div class="card">
            
            <div class="card-body shadow">
                <div class="table-responsive-lg  mt-2 p-1">
                    <h5>List of Strands</h5>
                    <table class="table table-hover table-bordered" id="strands_name">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Creation Date</th>
                                <th>Updation Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($allStrands as $item)
                               <tr>

                                    @if ($item->trashed())
                                            <td><del>{{ $item->name }}     </del></td>
                                            <td><del>{{ $item->created_at }}</del></td>
                                            <td><del>{{ $item->updated_at }}</del></td>
                                            <td>
                                                <form action="{{ route('admin.strand.restore', ['strand'=>$item->id]) }}" method="POST" class="d-inline hidden restore mr-2">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-recycle"></i>
                                                    </button>
                                                </form>
                                                
                                                <form action="{{ route('admin.strand.forceDelete', ['strand'=>$item->id]) }}" method="post" class="d-inline f-delete" >
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                </form>
                                            </td>
                                    @else
                                        
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->updated_at }}</td>
                                            <td>
                                                <a href="{{ route('admin.strand.edit', ['strand'=>$item->id]) }}" class="btn btn-primary mr-2"> <i class="fas fa-pen-fancy"></i> </a>
                                                
                                                <form action="{{ route('admin.strand.destroy', ['strand'=>$item->id]) }}" method="post" class="d-inline delete" >
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                                
                                                
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
        $('#strands_name').DataTable();

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
