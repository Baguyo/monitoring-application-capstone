@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        @pageHeader
            ADMIN | DASHBOARD
        @endpageHeader

    </div>



    <div class="container-fluid">
        <div class="row">

            {{-- TOTAL YEAR LEVEL --}}
            {{-- <div class="col-lg-4">
                <div class="card shadow text-white" style="background: linear-gradient(to bottom, #646aa4 ,#0d14e8)">
                    <div class="card-header ">
                        Number of Year Level
                    </div>
                    <div class="card-body text-sm-center">
                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                <h2 class="card-title mb-2  p-3">
                                    <i class="fas fa-signal fa-4x"></i>
                                </h2>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-6 my-auto">
                                <p class=" my-auto ">
                                    <a href="{{ route('admin.year.index') }}" class="text-white font-weight-bold" title="View year levels" >
                                    </a>
                                </p>

                                <p class="">
                                    <a href="{{ route('admin.year.create') }}" class="btn text-white  mr-1" title="Add year level">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                    <a href="{{ route('admin.year.index') }}" class="btn text-white" title="View year levels">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </p>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
            </div> --}}


            {{-- TOTAL SECTIONS --}}
            {{-- <div class="col-lg-4">
                <div class="card shadow text-white" style="background: linear-gradient(to left, #cb6349 ,#ff3700)">
                    <div class="card-header ">
                        Number of Sections
                    </div>
                    <div class="card-body text-sm-center">
                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                <h2 class="card-title mb-2  p-3">
                                    <i class="fas fa-building fa-4x"></i>
                                </h2>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-6 my-auto">
                                <p class=" my-auto ">
                                    <a href="{{ route('admin.section.index') }}" class="text-white font-weight-bold" title="View sections">
                                        
                                    </a>
                                </p>


                                <p class="">
                                    <a href="{{ route('admin.section.create') }}" class="btn text-white  mr-1" title="Add section">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                    <a href="{{ route('admin.section.index') }}" class="btn text-white" title="View sections">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </p>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
            </div> --}}

            {{-- TOTAL STUDENTS --}}
            <div class="col-lg-12">

                <div class="card shadow">
                    <div class="card-header">
                        <h6>Number of Students</h6>
                    </div>
                    <div class="card-body text-sm-center">
                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                <h2 class="card-title mb-2 text-info p-3">
                                    <i class="fas fa-users fa-4x"></i>
                                </h2>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-6 my-auto">
                                <p class=" my-auto ">
                                    <a href="{{ route('admin.student.index') }}" class=" font-weight-bold text-info"
                                        title="View students">
                                        Students: {{ $total_students }}
                                    </a>
                                </p>

                                {{-- EXTRA ACTION --}}

                                <p class="">
                                    <a href="{{ route('admin.student.create') }}" class="btn btn-info mr-1" title="Add student">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                    
                                    <a href="{{ route('admin.student.index') }}" class="btn btn-info" title="View students">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </p>
                            </div>


                        </div>
                    </div>
                </div>

            </div>

            {{-- TOTAL ADMINISTRATOR --}}
            {{-- <div class="col-lg-4">
                <div class="card shadow text-white" style="background: linear-gradient(to bottom, #a35695 ,#e301ae)">
                    <div class="card-header ">
                        Number of Administrator
                    </div>
                    <div class="card-body text-sm-center">
                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                <h2 class="card-title mb-2  p-3">
                                    <i class="fas fa-user-lock fa-4x"></i>
                                </h2>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-6 my-auto">
                                <p class=" my-auto ">
                                    <a href="{{ route('admin.users.index') }}" class="text-white font-weight-bold" title="View administrator">
                                        
                                    </a>
                                </p>

                                

                                <p class="text-white">
                                    <a href="{{ route('admin.users.create') }}" class="btn text-white mr-1" title="Add administrator">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', ['user'=>Auth::user()->id]) }}" class="btn text-white" title="Edit profile">
                                        <i class="fas fa-marker"></i>
                                    </a>
                                </p>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
            </div> --}}

            {{-- TOTAL MONITORING RECORDS --}}
            <div class="col-lg-12">

                {{-- <div class="card shadow text-white" style="background: linear-gradient(to bottom, #69a356 ,#2ee301)"> --}}
                <div class="card shadow " >
                    <div class="card-header"  >
                        <h6>Number of Monitoring Records</h6>
                    </div>
                    <div class="card-body text-sm-center">
                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                <h2 class="card-title mb-2 p-3">
                                    <i class="fas fa-calendar-check text-info fa-4x"></i>
                                </h2>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-6 my-auto">
                                <p class=" my-auto ">
                                    <a href="{{ route('admin.records.index') }}" class="text-info font-weight-bold"
                                        title="View records">
                                        Monitoring Records: {{ $total_monitoring_records }}
                                    </a>
                                </p>

                                {{-- EXTRA ACTION --}}

                                <p class="text-white">
                                    {{-- <a href="{{ route('admin.student.create') }}" class="btn text-white mr-1" title="Add student">
                                        <i class="fas fa-plus"></i>
                                    </a> --}}
                                    <a href="{{ route('admin.records.index') }}" class="btn btn-info"
                                        title="View records">
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
