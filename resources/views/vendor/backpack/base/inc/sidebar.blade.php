@if (auth()->check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="{{ Gravatar::fallback('https://placehold.it/160x160/3c334a/ffffff/&text='. mb_substr(auth()->user()->username, 0, 1))->get(auth()->user()->username) }}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{ auth()->user()->username }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header">{{ trans('backpack::base.administration') }}</li>
          <!-- ================================================ -->
          <!-- ==== Recommended place for admin menu items ==== -->
          <!-- ================================================ -->
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>

          <li class="header">CLIENTS</li>
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/client') }}"><i class="fa fa-users"></i> <span>Clients</span></a></li>
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/project') }}"><i class="fa fa-tasks"></i> <span>Projects</span></a></li>
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/task') }}"><i class="fa fa-bars"></i> <span>Task</span></a></li>

          <li class="header">Employees</li>
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/schedule') }}"><i class="fa fa-calendar"></i> <span>Schedule</span></a></li>


          <!-- ======================================= -->
          <li class="header">Dashboards</li>
          <li><a href="{{ route('dashboards.production.index') }}"><i class="fa fa-home"></i> <span>Production Dashboard</span></a></li>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
@endif
