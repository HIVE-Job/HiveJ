<!-- Left Panel-->
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

      <div class="navbar-header">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fa fa-bars"></i>
        </button>
        <a class="navbar-brand" href="./">HIVE Admin</a>
        <a class="navbar-brand hidden" href="./">AquaaTani Admin</a>
      </div>

      <div id="main-menu" class="main-menu collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li class=" {{ request()->is('admin/dashboard') ? 'active' : ''}} ">
            <a href="/admin/dashboard"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
          </li>
          <h3 class="menu-title">Management</h3><!-- /.menu-title -->

          <li class="menu-item-has-children dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-table"></i>User Management</a>
            <ul class="sub-menu children dropdown-menu">
              <li class="{{ request()->is('admin/manage-admins') ? 'active' : ''}}"><i class="fa fa-user"></i><a href="/admin/manage-admins">Admins</a></li>
              <li class="{{ request()->is('admin/manage-partners') ? 'active' : ''}}"><i class="fa fa-building-o"></i><a href="/admin/manage-partners">Partners / Recruiters</a></li>
              <li class="{{ request()->is('admin/manage-applicants') ? 'active' : ''}}"><i class="fa fa-users"></i><a href="/admin/manage-applicants">Job Applicants</a></li>
            </ul>
          </li>

          <li>
            <a class=" {{ request()->is('admin/manage-job-vacancies') ? 'active' : ''}} " href="{{route('a.vacancies')}}"> <i class="menu-icon fa fa-tasks"></i>Manage Job Vacancies</a>
          </li>

          <li>
            <a class=" {{ request()->is('admin/manage-job-applications') ? 'active' : ''}} " href="{{route('a.applications')}}"> <i class="menu-icon fa fa-tasks"></i>Manage Job Applications</a>
          </li>

        </ul>
      </div><!-- /.navbar-collapse -->
    </nav>
  </aside>
  <!-- End of Left Panel -->

