@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid py-3 px-3">

        @pageHeader
            ADMIN | Add Grade Level
        @endpageHeader

        
        

        
        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow" >
                    <div class="card-header" >
                        <h4 class="font-weight-normal">Grade level form</h4>
                    </div>
                    <div class="card-body">

                        
                        

                        

                        <form action="{{ route('admin.year.store') }}" method="post">
                            @csrf
                            <div class="mb-3">
                              @include('admin.year_level._form')
                                <button type="submit" class="btn btn-primary mt-3">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        


    </div>

    
@endsection
