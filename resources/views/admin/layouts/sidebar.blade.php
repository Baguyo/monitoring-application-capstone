<aside class="main-sidebar elevation-4 bg-white" > <!-- #1E49DE -->
    {{-- style="background: linear-gradient(to right, #1d40bc, #1E49DE)" --}}
    <a href="{{ route('admin.dashboard') }}" class="brand-link ">
        <img src="{{ Storage::url('defaults/logo.png') }}"
             alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3">
        <span class="brand-text text-dark font-weight-bold"> FBC MONITORING </span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @include('admin.layouts.menu')
            </ul>
        </nav>
    </div>

</aside>
