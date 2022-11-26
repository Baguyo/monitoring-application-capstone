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
                    <div class="card-header">
                        <h4 class="font-weight-normal">Edit student form</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('admin.student.update', ['student'=> $student->id]) }}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="mb-3">

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
                                    <label for="" class="form-label font-weight-normal">Guardian name</label>
                                    <input type="text" value="{{ old('guardian',$student->guardian) }}"
                                        name="guardian" id="" class="form-control @error('guardian') is-invalid @enderror" placeholder="" aria-describedby="helpId">
                                    @error('guardian')
                                        <p class="text-danger font-weight-bold">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label font-weight-normal">Address:</label>
                                    <input type="text" value="{{ old('address', $student->address) }}"
                                      class="form-control @error('address') is-invalid @enderror" name="address" id="" aria-describedby="helpId" placeholder="">                                  
                                    @error('address')
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

                                <div class="mb-3">
                                    <label for="" class="form-label font-weight-normal">Strand:</label>
                                    <select class="form-select form-select-lg form-control @error('strand') is-invalid @enderror" name="strand" id="strand">
                                        <option selected value="">Select one</option>
                                        @forelse ($all_strands as $strand)
                                            <option value="{{ $strand->id }}"> {{ $strand->name }} </option>
                                        @empty
                                            <option value="">No Strand</option>
                                        @endforelse
                                    </select>
                                    @error('strand')
                                        <p class="text-danger font-weight-bold">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label font-weight-normal">Grade Level:</label>
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
                                    <label for="" class="form-label font-weight-normal">Section:</label>
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
                var strand = $('#strand').val();
                $('#section').html('');

                var initial_url = '{{ route('admin.levels.section', ['level'=>0, 'strand'=>-1] ) }}';
                var url = initial_url.replace('0', level);
                url = url.replace('-1', strand);

                

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
