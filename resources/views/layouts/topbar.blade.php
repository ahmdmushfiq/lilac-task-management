<nav class="menu">
    <ul class="menu-left">
        <li class="button text">
            {{ Auth::user()->name }}'s Dashboard
        </li>
    </ul>
    <ul class="menu-right">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="button"><i class="ri-logout-box-r-line"></i>Logout</button>
        </form>
    </ul>
</nav>