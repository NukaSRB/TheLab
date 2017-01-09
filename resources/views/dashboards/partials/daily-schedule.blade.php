<nav class="panel">
  <div class="panel-heading is-clearfix">
    <div class="is-pulled-left">
      Daily Schedule
    </div>
    <div class="is-pulled-right">
      <a href="https://www.toggl.com/app/reports/summary/901085/period/today/users/{{ auth()->user()->getProvider('toggl')->social_id }}/billable/both"
         class="button is-dark is-outlined is-small"
         target="_blank"
      >
        <span class="icon is-small">
          <i class="fa fa-bar-chart"></i>
        </span>
      </a>
    </div>
  </div>
  @each('dashboards.partials.schedule', $dailySchedule, 'schedule')
</nav>
