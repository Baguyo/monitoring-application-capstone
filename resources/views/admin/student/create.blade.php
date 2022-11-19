@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid py-3 px-3">

        @pageHeader
            ADMIN | Add student
        @endpageHeader

        
        

        
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="font-weight-normal">Add student form</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('admin.student.store') }}" method="post">
                            @csrf
                            <div class="mb-3">

                                <div class="mb-3">
                                  <label for="" class="form-label font-weight-normal">Name:</label>
                                  <input type="text" value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror " name="name" id="" aria-describedby="helpId" placeholder="">                                  
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

                                 <div class="mb-3">
                                   <label for="" class="form-label font-weight-normal">Guardian name</label>
                                   <input type="text" name="guardian" id="" class="form-control @error('guardian') is-invalid @enderror" placeholder="" aria-describedby="helpId">
                                   @error('guardian')
                                        <p class="text-danger font-weight-bold">{{ $message }}</p>
                                    @enderror
                                 </div>


                                <div class="mb-3">
                                    <label for="" class="form-label font-weight-normal">Address</label>
                                    <input type="text" value="{{ old('address') }}"
                                      class="form-control @error('address') is-invalid @enderror" name="address" id="" aria-describedby="helpId" placeholder="">                                  
                                    @error('address')
                                        <p class="text-danger font-weight-bold">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label font-weight-normal">Contact Number</label>
                                    <input type="tel" value="{{ old('contact_number', "+63") }}"  pattern="[+]{1}[0-9]{11,14}"
                                      class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" id="" aria-describedby="helpId" placeholder="">
                                      @error('contact_number')
                                        <p class="text-danger font-weight-bold">{{ $message }}</p>
                                    @enderror
                                        <p class="form-text text-muted">
                                            format: +639100100101
                                        </p>
                                  </div>

                                <div class="mb-3">
                                    <label for="" class="form-label font-weight-normal">Grade Level</label>
                                    <select class="form-select form-select-lg form-control @error('level') is-invalid @enderror" name="level" id="level" >
                                        <option selected value="">Select one</option>
                                        @forelse ($all_year_level as $item)
                                            
                                            <option value="{{ $item->id }}"> {{ $item->level }} </option>
                                        @empty
                                            <option value="">No Grade Level</option>
                                        @endforelse
                                    </select>
                                    @error('level')
                                        <p class="text-danger font-weight-bold">{{ $message }}</p>
                                    @enderror
                                </div>

                                

                                <div class="mb-3">
                                    <label for="" class="form-label font-weight-normal">Section</label>
                                    <select class="form-select form-select-lg form-control @error('section') is-invalid @enderror" name="section" id="section">

                                    </select>
                                    @error('section')
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


    <script type="module">

        $(document).ready(function () {
            
            $('#level').change(function (e) { 
                var level = this.value;
                $('#section').html('');

                var initial_url = '{{ route('admin.levels.section', ['level'=>0] ) }}';
                var url = initial_url.replace('0', level);

                $.ajax({
                    type: "GET",
                    url: url,
                    success: function (response) {
                        $("#section").append("<option value=''>--SELECT--</option>");
                        $.each(response, function (key, value) { 
                            
                            $("#section").append("<option value='"+ value.id +"'   >"+ value.name +"</option>");
                        });
                    }
                });
            });

        });

    </script>
    
@endsection
