<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::is('admin_dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Dashboard</p>
    </a>
</li>

{{-- <li class="nav-item">
    <a href="{{ route('admin.strand.index') }}" class="nav-link {{ request()->route()->named('admin.strand*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-file"></i>
        <p>Strands</p>
    </a>
</li> --}}

{{-- <li class="nav-item">
    <a href="{{ route('admin.year.index') }}" class="nav-link {{ request()->route()->named('admin.year*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-chart-bar"></i>
        <p>Grade Level</p>
    </a>
</li> --}}

{{-- <li class="nav-item">
    <a href="{{ route('admin.section.index') }}" class="nav-link {{ request()->route()->named('admin.section*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-building"></i>
        <p>Sections</p>
    </a>
</li> --}}

<li class="nav-item">
    <a href="{{ route('admin.student.index') }}" class="nav-link {{ request()->route()->named('admin.student*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>Students</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('admin.users.edit', ['user'=>Auth()->id()]) }}" class="nav-link {{ request()->route()->named('admin.users*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-lock"></i>
        <p>Edit Administrator</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('admin.scan') }}" class="nav-link {{ request()->route()->named('admin.scan*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-qrcode"></i>
        <p>Scan QR Code</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('admin.records.index') }}" class="nav-link {{ request()->route()->named('admin.records*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-calendar-check"></i>
        <p>MS Records</p>
    </a>
</li>