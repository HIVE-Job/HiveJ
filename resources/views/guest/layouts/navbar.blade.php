<nav class="mx-auto site-navigation">
  <ul class="site-menu js-clone-nav d-none d-xl-block ml-0 pl-0">
    <li><a href="/" class="nav-link @if(request()->is('/')) active @endif">Home</a></li>
    <li><a href="{{route('g.vacancies')}}" class="nav-link @if(request()->is('vacancy') || request()->is('vacancy/*')|| request()->is('vacancy-freelancer') || request()->is('vacancy-fulltime')) active @endif">All Job Vacancies</a></li>
    <li><a href="/testimoni" class="nav-link @if(request()->is('testimoni')) active @endif">Testimonials</a></li>
    <li><a href="/about-us" class="nav-link @if(request()->is('about-us')) active @endif">About Us</a></li>
  </ul>
</nav>
