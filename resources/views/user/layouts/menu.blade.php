<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('user.dashboard') }}" class="nav-link {{ Request::is('user') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Dashboard</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('user.profile.edit', ['profile'=>auth()->user()->id]) }}" class="nav-link {{ request()->route()->named('user.profile*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user"></i>
        <p>Profile</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('user.records.index') }}" class="nav-link {{ request()->route()->named('user.records*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-clipboard"></i>
        <p>Monitoring records</p>
    </a>
</li>

{{-- <li class="nav-item">
    <a href="{{ route('user.contact.create') }}" class="nav-link {{ request()->route()->named('user.contact*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-phone"></i>
        <p>Contact Admin</p>
    </a>
</li>  --}}