@extends('user.layouts.app')

@section('content')
    <div class="container-fluid p-3">
        @pageHeader
          USER | Contact Admin
        @endpageHeader
        <hr>

        

        <div class="card col-lg-7">
            <div class="card-header">
                <h5>Contact admin form</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('user.contact.send') }}" method="post">
                    @csrf
                    
                    <div class="mb-3">
                      <label for="" class="form-label font-weight-normal">Message:</label>
                      <textarea class="form-control @error('message') is-invalid @enderror" name="message" id="" rows="3">{{ old('message') }}</textarea>
                      @error('message')
                            <p class="text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <input type="submit" value="Submit" class="btn btn-primary">

                    
                </form>
            </div>
        </div>

       

    </div>
   
@endsection