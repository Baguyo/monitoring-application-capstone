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
            <div class="col-lg-4">
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
                                        Year Level: {{ $total_year_level }} 
                                    </a>
                                </p>

                                {{-- EXTRA ACTION --}}

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
            </div>


            {{-- TOTAL SECTIONS --}}
            <div class="col-lg-4">
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
                                        Sections: {{ $total_sections }} 
                                    </a>
                                </p>

                                {{-- EXTRA ACTION --}}

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
            </div>

            {{-- TOTAL STUDENTS --}}
            <div class="col-lg-4">

                <div class="card shadow text-white" style="background: linear-gradient(to bottom, #289290 ,#01dce3)">
                    <div class="card-header ">
                        Number of Students
                    </div>
                    <div class="card-body text-sm-center">
                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                <h2 class="card-title mb-2  p-3">
                                    <i class="fas fa-users fa-4x"></i>
                                </h2>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-6 my-auto">
                                <p class=" my-auto ">
                                    <a href="{{ route('admin.student.index') }}" class="text-white font-weight-bold" title="View students">
                                        Students: {{ $total_students }} 
                                    </a>
                                </p>

                                {{-- EXTRA ACTION --}}

                                <p class="text-white">
                                    <a href="{{ route('admin.student.create') }}" class="btn text-white mr-1" title="Add student">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                    <a href="{{ route('admin.student.index') }}" class="btn text-white" title="View students">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </p>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>

            </div>

            {{-- TOTAL ADMINISTRATOR --}}
            <div class="col-lg-4">
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
                                        Administrator: {{ $total_admin }} 
                                    </a>
                                </p>

                                {{-- EXTRA ACTION --}}

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
            </div>

            {{-- TOTAL MONITORING RECORDS --}}
            <div class="col-lg-4">
                
                <div class="card shadow text-white" style="background: linear-gradient(to bottom, #69a356 ,#2ee301)">
                    <div class="card-header ">
                        Number of Monitoring Records
                    </div>
                    <div class="card-body text-sm-center">
                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                <h2 class="card-title mb-2  p-3">
                                    <i class="fas fa-calendar-check fa-4x"></i>
                                </h2>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-6 my-auto">
                                <p class=" my-auto ">
                                    <a href="{{ route('admin.records.index') }}" class="text-white font-weight-bold" title="View records">
                                        Monitoring Records: {{ $total_monitoring_records }} 
                                    </a>
                                </p>

                                {{-- EXTRA ACTION --}}

                                <p class="text-white">
                                    {{-- <a href="{{ route('admin.student.create') }}" class="btn text-white mr-1" title="Add student">
                                        <i class="fas fa-plus"></i>
                                    </a> --}}
                                    <a href="{{ route('admin.records.index') }}" class="btn text-white" title="View records">
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
