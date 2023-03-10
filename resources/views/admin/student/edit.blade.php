@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid py-3 px-3">

        @pageHeader
            ADMIN | Edit student
        @endpageHeader
        
        <hr>
        

        
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-info">
                        <h4 class="font-weight-normal">Edit student form</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('admin.student.update', ['student'=> $student->id]) }}" method="post" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="mb-3">

                                <div class="mb-3">
                                    <label for="" class="form-label font-weight-normal">Student Image: </label>
                                    <input type="file" class="" name="image" id="" placeholder="" aria-describedby="fileHelpId">
                                    @error('image')
                                          <p class="text-danger font-weight-bold">{{ $message }}</p>
                                      @enderror
                                </div>

                                <div class="mb-3">
                                    <img src=" {{ ($student->user->img_path) ? Storage::url($student->user->img_path) :Storage::url('defaults/logo.png') }} " 
                                         class="shadow" alt="" height="100" width="100">
                                </div>

                                <div class="mb-3">
                                  <label for="" class="form-label font-weight-normal">Name:</label>
                                  <input type="text" value="{{ old('name', $student->user->name) }}"
                                    class="form-control @error('name') is-invalid @enderror " name="name" id="" aria-describedby="helpId" placeholder="">                                  
                                    @error('name')
                                        <p class="text-danger font-weight-bold">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                  <label for="" class="form-label font-weight-normal">Email</label>
                                  <input type="email" value="{{ old('email', $student->user->email) }}"
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
                                    <label for="" class="form-label font-weight-normal">Student Number</label>
                                    <input type="number" value="{{ old('student_number',$student->student_number) }}"
                                     class="form-control  @error('student_number') is-invalid @enderror" name="student_number" id="" placeholder="">
                                    @error('student_number')
                                          <p class="text-danger font-weight-bold">{{ $message }}</p>
                                      @enderror
                                  </div>


                                <div class="mb-3">

                                    <label for="" class="form-label font-weight-normal">Contact Number</label>
                                    <div class="input-group ">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">+63</span>
                                        </div>
                                        <input type="tel" value="{{ old('contact_number', $student->contact_number) }}" 
                                        class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" id="" aria-describedby="helpId" placeholder="">
                                    </div>
                                    @error('contact_number')
                                            <p class="text-danger font-weight-bold">{{ $message }}</p>
                                        @enderror
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
