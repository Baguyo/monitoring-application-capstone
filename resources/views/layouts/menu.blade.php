<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('user.dashboard') }}" class="nav-link {{ Request::is('user_dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>
