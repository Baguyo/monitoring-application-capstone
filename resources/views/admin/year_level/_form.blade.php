    <label for="" class="font-weight-normal">Year:</label>
    <input type="number" value="{{ old('level', $year->level ?? null) }}"
    class="form-control @error('level') is-invalid @enderror " name="level" id="" aria-describedby="helpId" placeholder="">
        
        @error('level')
        <p class="text-danger font-weight-bold">{{ $message }}</p>
        @enderror