<div class="card" style="background: linear-gradient(to right, #0975f9fb , #ade9ff  )">
    <div class="card-body">
        {{-- <h1 class="text-black-50"> --}}
        <h1 class="text-white-50">
            {{ $slot }}
        </h1>
        {{-- {{ auth()->user()->type }} --}}
    </div>
</div>