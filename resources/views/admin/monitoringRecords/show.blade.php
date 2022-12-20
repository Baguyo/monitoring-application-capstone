@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-3">

        @pageHeader
            ADMIN | Monitoring Records
        @endpageHeader

        <hr>

        

        <div class="card">
            
            <div class="card-body shadow">
                <form action="{{ route('admin.records.show') }}" method="GET">
                    <div class="form-row">
                      
                      <div class="col">
                            <label for="" class="form-label">Name</label>
                            
                            <select class="form-select form-control @error('student') is-invalid @enderror" name="student" id="students">
                                <option value=" ">--SELECT STUDENT--</option>  
                                @forelse ($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->user->name }}</option>
                                @empty
                                    <option value=" ">--NO STUDENT--</option>
                                @endforelse
                            </select>                        

                            @error('student')
                                <p class="text-danger font-weight-bold">{{ $message }}</p>
                            @enderror

                      </div>

                      <div class="col">
                        <label for="" class="form-label">Date from</label>
                        <input type="date" name="date-from" id="" class="form-control @error('date-from') is-invalid @enderror" placeholder="" aria-describedby="helpId">
                        @error('date-from')
                            <p class="text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                      </div>

                      <div class="col">
                        <label for="" class="form-label">Date to</label>
                        <input type="date" name="date-to" id="" class="form-control @error('date-to') is-invalid @enderror" placeholder="" aria-describedby="helpId">
                        @error('date-to')
                            <p class="text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                      </div>

                      <div class="col">
                        <label for="" class="invisible">Filter</label>
                        <input type="submit" value="Filter" class="btn btn-primary form-control">
                      </div>

                    </div>
                </form>    
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive-lg mt-4">
                    
                    

                    <h5>List of student monitoring record</h5>

                    {{-- <form action="{{ route('admin.records.export',['id'=>'asd', 'date-from'=> 'das', 'date-to'=>'asd'] ) }}" method="" class="mb-2">
                        <input type="submit" value="Export as CSV" class="btn btn-primary">
                    </form> --}}

                    <a href="{{ route('admin.records.export',['sid'=>request('student')."+".request('date-from')."+".request('date-to')   ] ) }}"
                        class="btn btn-primary my-2">
                        Export as CSV
                    </a>
                        
                        
                        
                            <table class="table table-hover table-bordered table-responsive" id="monitoring-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>In</th>
                                        <th>Out</th>
                                        <th>In</th>
                                        <th>Out</th>
                                        <th>In</th>
                                        <th>Out</th>
                                        <th>In</th>
                                        <th>Out</th>
                                        <th>In</th>
                                        <th>Out</th>
                                    </tr>
                                </thead>    
                                
                                @forelse ($records as $item)
                                    
                                <tr>
                                    <td>{{ $item->user_name }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{  ($item->first_in) ? date('h:i:A', strtotime($item->first_in)) : "" }}</td>
                                    <td>{{  ($item->first_out) ? date('h:i:A', strtotime($item->first_out)) : ""  }}</td>
                                    <td>{{  ($item->second_in) ? date('h:i:A', strtotime($item->second_in)) : "" }}</td>
                                    <td>{{  ($item->second_out) ? date('h:i:A', strtotime($item->second_out)) : "" }}</td>
                                    <td>{{  ($item->third_in) ? date('h:i:A', strtotime($item->third_in)) : "" }}</td>
                                    <td>{{  ($item->third_out) ? date('h:i:A', strtotime($item->third_out)) : "" }}</td>
                                    <td>{{  ($item->fourth_in) ? date('h:i:A', strtotime($item->fourth_in)) : "" }}</td>
                                    <td>{{  ($item->fourth_out) ? date('h:i:A', strtotime($item->fourth_out)) : "" }}</td>
                                    <td>{{  ($item->fifth_in) ? date('h:i:A', strtotime($item->fifth_in)) : "" }}</td>
                                    <td>{{  ($item->fifth_out) ? date('h:i:A', strtotime($item->fifth_out)) : "" }}</td>
                                    
                                </tr>   
                                @empty
                                    <td colspan="7" class="text-center">No record for student's selected date range</td>
                                @endforelse
                                
                            </table>
                        
                        

                    </div>
                    
                </div>
            </div>
        </div>

    </div>
    <script type="module">
        $('#monitoring-table').dataTable();
    </script>
   
@endsection