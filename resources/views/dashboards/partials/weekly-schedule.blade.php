<nav class="panel">
  <div class="panel-heading is-clearfix">
    <div class="is-pulled-left">
      Weekly Schedule
    </div>
    <div class="is-pulled-right">
      {{--todo - convert this to the user's toggl id--}}
      <a href="https://www.toggl.com/app/reports/summary/901085/period/thisWeek/users/1777547/billable/both"
         class="button is-dark is-outlined is-icon-only is-small"
         target="_blank"
      >
        <span class="icon is-small">
          <i class="fa fa-fw fa-bar-chart"></i>
        </span>
      </a>
    </div>
  </div>
  @each('dashboards.partials.schedule', $weeklySchedule, 'schedule')
</nav>
