<nav class="mx-auto site-navigation">
  <ul class="site-menu js-clone-nav d-none d-xl-block ml-0 pl-0">
    <li><a href="{{route('u.homepage')}}" class="nav-link {{ request()->is('user/beranda') ? 'active' : ''}}">Home</a></li>
    <li><a href="{{route('u.vacancies')}}" class="nav-link {{ request()->is('user/vacancy') || request()->is('user/vacancy/*') || request()->is('user/vacancy-freelancer') || request()->is('user/vacancy-fulltime') ? 'active' : ''}}">All Jobs</a></li>
    <li><a href="{{route('u.applications')}}" class="nav-link {{ request()->is('user/lamaran') || request()->is('user/lamaran/*') ? 'active' : ''}}">My Applications</a></li>
    <li><a href="{{route('u.notifications')}}" class="nav-link {{ request()->is('user/notifikasi') ? 'active' : ''}}">Notifications @if($unread_notif > 0)({{ $unread_notif }})@endif</a></li>
  </ul>
</nav>

