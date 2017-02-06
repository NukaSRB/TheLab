<div class="navbar-custom-menu pull-left">
  <ul class="nav navbar-nav">
    <!-- =================================================== -->
    <!-- ========== Top menu items (ordered left) ========== -->
    <!-- =================================================== -->

  <!-- <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> <span>Home</span></a></li> -->

    <!-- ========== End of top menu left items ========== -->
  </ul>
</div>


<div class="navbar-custom-menu">
  <ul class="nav navbar-nav">
    <!-- ========================================================= -->
    <!-- ========== Top menu right items (ordered left) ========== -->
    <!-- ========================================================= -->

    <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> <span>Home</span></a></li>

    @if (auth()->guest())
      <li><a href="{{ route('auth.login') }}">{{ trans('backpack::base.login') }}</a></li>
    @else
      <li>
        <a href="{{ route('auth.logout') }}"><i class="fa fa-btn fa-sign-out"></i> {{ trans('backpack::base.logout') }}
        </a></li>
  @endif

  <!-- ========== End of top menu right items ========== -->
  </ul>
</div>
