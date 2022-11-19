@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid py-3 px-3">
        

        @pageHeader
            ADMIN | Create Administrator
        @endpageHeader

        <hr>
        

        
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="font-weight-normal">Add administrator form</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('admin.users.store') }}" method="post">
                            @csrf

                                <div class="mb-3">
                                    <label for="" class="form-label font-weight-normal">Name:</label>
                                    <input type="text" name="name" id="" class="form-control @error('name') is-invalid @enderror"
                                    placeholder="" aria-describedby="helpId" value="{{ old('name') }}" >

                                    @error('name')
                                        <p class="text-danger font-weight-bold">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label font-weight-normal">Email</label>
                                    <input type="email" value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror" name="email" id="" aria-describedby="emailHelpId" placeholder="abc@mail.com">
                                    @error('email')
                                          <p class="text-danger font-weight-bold">{{ $message }}</p>
                                      @enderror
                                  </div>
  
                                  <div class="mb-3">
                                    <label for="" class="form-label font-weight-normal">Password</label>
                                    <input type="password" class="form-control  @error('password') is-invalid @enderror" name="password" id="" placeholder="">
                                    @error('password')
                                          <p class="text-danger font-weight-bold">{{ $message }}</p>
                                      @enderror
                                  </div>
  
                                  <div class="mb-3">
                                      <label for="" class="form-label font-weight-normal">Retype Password</label>
                                      <input type="password" class="form-control" name="password_confirmation" id="" placeholder="">
                                   </div>

                                <button type="submit" class="btn btn-primary mt-3">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        


    </div>

    
@endsection
