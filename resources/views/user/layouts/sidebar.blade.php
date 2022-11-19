<aside class="main-sidebar elevation-4" style="background: linear-gradient(to right, #1d40bc, #1E49DE)">
    <a href="{{ route('home') }}" class="brand-link">
        <img src="{{ Storage::url('defaults/logo.jpg') }}"
             alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3">
        <span class="brand-text text-white font-weight-bold"> FBC MONITORING </span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @include('user.layouts.menu')
            </ul>
        </nav>
    </div>

</aside>
