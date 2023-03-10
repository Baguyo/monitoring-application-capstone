@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid py-3 px-3">
        
        @pageHeader
            ADMIN | Edit Profile
        @endpageHeader

        <hr>
        

        
        <div class="row">
            <div class="col-lg-4 text-center mb-2">
                {{-- @if (!$admin->img_path)
                    <img src="https://via.placeholder.com/250.png/09f/fff" alt="" class="rounded-circle img-fluid">
                @else
                    <img src={{ $admin->showImage() }} alt="" class="rounded-circle img-fluid">
                @endif --}}

                <img src={{ ($admin->img_path) ? $admin->showImage() : Storage::url('defaults/logo.jpg') }} 
                alt="" class="rounded-circle img-fluid">

            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="font-weight-normal">Edit Profile form</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('admin.users.update', ['user' => $admin->id]) }}" method="post" enctype="multipart/form-data">
                            @method("PUT")
                            @csrf

                            @validationError @endvalidationError

                                {{-- <div class="mb-3">
                                  <label for="" class="form-label font-weight-normal">Choose image file:</label>
                                  <input type="file" class="@error('avatar') is-invalid @enderror" name="avatar" id="">

                                    @error('avatar')
                                        <p class="text-danger font-weight-bold">{{ $message }}</p>
                                    @enderror
                                </div> --}}

                                <div class="mb-3">
                                    <label for="" class="form-label font-weight-normal">Name:</label>
                                    <input type="text" value="{{ $admin->name }}" @disabled(true) class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label font-weight-normal">Email</label>
                                    <input type="email" value="{{ old('email', $admin->email) }}" @disabled(true)
                                    class="form-control">
                                    @error('email')
                                          <p class="text-danger font-weight-bold">{{ $message }}</p>
                                      @enderror
                                  </div>
  
                                  <div class="mb-3">
                                    <label for="" class="form-label font-weight-normal">Password</label>
                                    <input type="password" class="form-control  @error('password') is-invalid @enderror" name="password" id="" placeholder=""> 
                                  </div>
  
                                  <div class="mb-3">
                                      <label for="" class="form-label font-weight-normal">Retype Password</label>
                                      <input type="password" class="form-control" name="password_confirmation" id="" placeholder="">
                                   </div>

                                   <div class="mb-3">
                                    <label for="" class="form-label font-weight-normal">Time to send SMS</label>
                                    <input type="time" class="form-control" name="time" id="" placeholder="">
                                 </div>

                                <button type="submit" class="btn btn-info mt-3">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        


    </div>

    
@endsection
