@extends('user.layouts.app')

@section('content')
    <div class="container-fluid py-3 px-3">
        @pageHeader
            USER | PROFILE
        @endpageHeader
        <hr>
        

        
        <div class="row">
            <div class="col-lg-4 text-center mb-2">
                <img src={{ ($user->img_path) ? $user->showImage() : Storage::url('defaults/logo.jpg') }} 
                alt="" class="rounded-circle img-fluid">

            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="font-weight-normal">Edit Profile form</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('user.profile.update', ['profile'=>$user->id]) }}" method="post" enctype="multipart/form-data">
                            @method("PUT")
                            @csrf

                                <div class="mb-3">
                                  <label for="" class="form-label font-weight-normal">Choose image file:</label>
                                  <input type="file" class="@error('avatar') is-invalid @enderror" name="avatar" id="">

                                    @error('avatar')
                                        <p class="text-danger font-weight-bold">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label font-weight-normal">Name:</label>
                                    <input type="text" name="name" id="" class="form-control @error('name') is-invalid @enderror"
                                    placeholder="" aria-describedby="helpId" value="{{ old('name', $user->name) }}" >
                                    @error('name')
                                        <p class="text-danger font-weight-bold">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label font-weight-normal">Email</label>
                                    <input type="email" value="{{ old('email', $user->email) }}"
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

                                   <div class="mb-3">
                                     <label for="" class="form-label font-weight-normal">Address</label>
                                     <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="" rows="3">{{ old('address', $user->student->address) }}
                                    </textarea>
                                     @error('address')
                                          <p class="text-danger font-weight-bold">{{ $message }}</p>
                                      @enderror
                                   </div>

                                    <div class="mb-3">
                                        <label for="" class="form-label font-weight-normal">Guardian Name:</label>
                                        <input type="text" name="guardian" id="" class="form-control @error('guardian') is-invalid @enderror"
                                        placeholder="" aria-describedby="helpId" value="{{ old('guardian', $user->student->guardian) }}" >
                                        @error('guardian')
                                            <p class="text-danger font-weight-bold">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    
                                    {{-- <div class="mb-3">
                                        <label for="" class="form-label font-weight-normal">Contact Number</label>
                                        <input type="tel" value="{{ old('contact_number', $user->student->contact_number ?? "+63") }}"  pattern="[+]{1}[0-9]{11,14}"
                                        class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" id="" aria-describedby="helpId" placeholder="">
                                        @error('contact_number')
                                            <p class="text-danger font-weight-bold">{{ $message }}</p>
                                        @enderror
                                            <p class="form-text text-muted">
                                                Sample format: +639100100101
                                            </p>
                                    </div> --}}

                                    <label for="" class="form-label font-weight-normal">Contact Number</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">+63</span>
                                        </div>
                                        <input type="tel" value="{{ old('contact_number', $user->student->contact_number ?? "+63") }}" 
                                        class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" id="" aria-describedby="helpId" placeholder="">
                                        @error('contact_number')
                                            <p class="text-danger font-weight-bold">{{ $message }}</p>
                                        @enderror
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
