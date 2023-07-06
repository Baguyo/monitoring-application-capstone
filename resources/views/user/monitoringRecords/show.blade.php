@extends('user.layouts.app')

@section('content')
    <div class="container-fluid p-3">
        
        @pageHeader
          USER | Monitoring Records
        @endpageHeader
        <hr>

        

        <div class="card">
            
            <div class="card-body">
                <form action="{{ route('user.records.show') }}" method="GET">
                    <div class="form-row">
                     

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
                            <input type="submit" value="Filter" class="btn btn-info form-control">
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

                    {{-- <a href="{{ route('user.records.export',['sid'=>request('student')."+".request('date-from')."+".request('date-to')   ] ) }}"
                        class="btn btn-primary my-2">
                        Export as CSV
                    </a> --}}
                        
                        
                        
                            <table class="table table-hover table-bordered" id="monitoring-table">
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
                                    <td>{{ $item->student->user->name }}</td>
                                    <td>{{ $item->date }}</td>
                                    @monitoringRecord(['record'=>$item->first_in])@endmonitoringRecord
                                    @monitoringRecord(['record'=>$item->first_out])@endmonitoringRecord
                                    @monitoringRecord(['record'=>$item->second_in])@endmonitoringRecord
                                    @monitoringRecord(['record'=>$item->second_out])@endmonitoringRecord
                                    @monitoringRecord(['record'=>$item->third_in])@endmonitoringRecord
                                    @monitoringRecord(['record'=>$item->third_out])@endmonitoringRecord
                                    @monitoringRecord(['record'=>$item->fourth_in])@endmonitoringRecord
                                    @monitoringRecord(['record'=>$item->fourth_out])@endmonitoringRecord
                                    @monitoringRecord(['record'=>$item->fifth_in])@endmonitoringRecord
                                    @monitoringRecord(['record'=>$item->fifth_out])@endmonitoringRecord
                                    
                                </tr>   
                                @empty
                                    <tr>
                                        <td colspan="" class="text-center">No record for student's selected date range</td>
                                    </tr>
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