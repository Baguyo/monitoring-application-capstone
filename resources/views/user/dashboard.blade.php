@extends('user.layouts.app')

@section('content')
    <div class="container-fluid">
        

        @pageHeader
            USER | DASHBOARD
        @endpageHeader

        
        <div class="row">

            {{-- NUMBER OF MONITORING RECORDS --}}
            <div class="col-lg-12">
                <div class="card shadow border border-dark" >
                    <div class="card-header bg-info">
                        Number of Monitoring Records
                    </div>
                    <div class="card-body text-sm-center">
                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                <h2 class="card-title mb-2  p-3">
                                    <i class="fas fa-calendar-check text-info fa-4x"></i>
                                </h2>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-6 my-auto">
                                <p class=" my-auto ">
                                    <a href="{{ route('user.records.index') }}" class="text-info font-weight-bold" title="View records">
                                        Monitoring Records: {{ $total_monitoring_records }} 
                                    </a>
                                </p>

                                {{-- EXTRA ACTION --}}

                                <p class="text-white">
                                    {{-- <a href="{{ route('admin.student.create') }}" class="btn text-white mr-1" title="Add student">
                                        <i class="fas fa-plus"></i>
                                    </a> --}}
                                    <a href="{{ route('user.records.index') }}" class="btn btn-info" title="View records">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </p>
                            </div>
                            
                            
                        </div>
                    </div>
                
                </div>
            </div>

          
        </div>

    </div>
@endsection
