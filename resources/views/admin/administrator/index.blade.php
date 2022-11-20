@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-3">
        
        @pageHeader
            ADMIN | Administrator
        @endpageHeader

        <hr>

        <a href="{{ route('admin.users.create') }}" class="btn btn-primary my-3">Add Administrator</a>

        <div class="card" >
            <div class="card-body shadow">
                <div class="table-responsive-lg mt-4">
                    <h5>List of Administrator</h5>

                        

                        <table class="table table-hover table-bordered" id="section-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Date creation</th>
                                    <th>Date updation</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @forelse ($administrator as $item)
                                    
                                    
                                    <tr>
                                    
                                        <td> {{ $item->name }} </td>
                                        <td> {{ $item->email }} </td>
                                        <td> {{ $item->created_at }} </td>
                                        <td> {{ $item->updated_at }} </td>
                                        <td>
                                            @if ($item->id === Auth::user()->id)
                                                <a href="{{ route('admin.users.edit', ['user'=>$item->id]) }}" class="btn btn-primary mr-2"> <i class="fas fa-pen-fancy"></i> </a>
                                                
                                                <form action="{{ route('admin.users.destroy', ['user'=>$item->id]) }}" method="post" class="d-inline delete-user" >
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>    
                                            @endif
                                            
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
        
      

    

        $('.delete-user').submit(function (e) { 
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to delele your account ?',
                text: " deleted account cannot be reverted ",
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