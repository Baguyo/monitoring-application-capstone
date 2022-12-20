@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-3">
        
        @pageHeader
            ADMIN | Monitoring Records
        @endpageHeader
        <hr>

        

        <div class="card">
            
            <div class="card-body">
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

       
        

    </div>
   
@endsection