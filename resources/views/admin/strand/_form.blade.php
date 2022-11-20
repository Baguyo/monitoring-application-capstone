    <label for="" class="font-weight-normal">Strand:</label>
    <input type="text" value="{{ old('strand', $strand->name ?? null) }}"
    class="form-control @error('strand') is-invalid @enderror " name="strand" id="" aria-describedby="helpId" placeholder="">
        
        @error('strand')
        <p class="text-danger font-weight-bold">{{ $message }}</p>
        @enderror