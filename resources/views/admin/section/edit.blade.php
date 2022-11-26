@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid py-3 px-3">

        @pageHeader
            ADMIN | Edit section
        @endpageHeader
        
        <hr>
        

        
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="font-weight-normal">Add section form</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('admin.section.update', ['section'=>$section_to_edit->id]) }}" method="post">
                            @method("PUT")
                            @csrf
                            <div class="mb-3">

                                <div class="mb-3">
                                    <label for="" class="form-label font-weight-normal">Strand:</label>
                                    <select class="form-select form-select-lg form-control @error('strand') is-invalid @enderror" name="strand" id="" >
                                        
                                        <option selected value="{{ $section_to_edit->strands->id }}"> {{ $section_to_edit->strands->name }} </option>
                                        @forelse ($strands as $item)
                                            <option value="{{ $item->id }}" @if (old('strand') == $item->id) selected @endif > {{ $item->name }} </option>
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
                                    <select class="form-select form-select-lg form-control @error('level') is-invalid @enderror" name="level" id="" >
                                        
                                        <option selected value="{{ $section_to_edit->yearLevel->id }}"> {{ $section_to_edit->yearLevel->level }} </option>
                                        @forelse ($all_year_level as $item)
                                            <option value="{{ $item->id }}" @if (old('level') == $item->id) selected @endif > {{ $item->level }} </option>
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
                                  <input type="text" name="section" id="" class="form-control @error('section') is-invalid @enderror"
                                   placeholder="" aria-describedby="helpId" value="{{ old('section', $section_to_edit->name) }}" >

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

    
@endsection
