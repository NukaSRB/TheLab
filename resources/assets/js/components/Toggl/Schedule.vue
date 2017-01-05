<template>
  <nav class="panel">
    <div class="panel-heading is-clearfix">
      <div class="is-pulled-left">
        {{ type }} Schedule
      </div>
      <div class="is-pulled-right">
        <!--todo - convert this to the user's toggl id-->
        <a href="https://www.toggl.com/app/reports/summary/901085/period/today/users/1777547/billable/both"
           class="button is-dark is-outlined is-small"
           target="_blank"
        >
        <span class="icon is-small">
          <i class="fa fa-bar-chart"></i>
        </span>
        </a>
      </div>
    </div>
    <div class="panel-block" v-for="schedule in schedules">
      <div class="columns" :style="{ color: '#' + schedule.client.color }">
        <div class="column is-half">
          {{ schedule.client.label }}
          ({{ schedule.percentage }}%)
        </div>
        <div class="column is-one-quarter">{{ schedule.time }}hrs</div>
        <div class="column is-one-quarter">{{ schedule.hours }}hrs</div>
      </div>
      <div class="columns">
        <div class="column is-whole">
          <progress class="progress"
                    :class="schedule.client.name"
                    :value="schedule.percentage"
                    max="100"
          >
            {{ schedule.percentage }}%
          </progress>
        </div>
      </div>
    </div>
  </nav>
</template>
<style>

</style>
<script>
  export default {
    props: ['type', 'schedules'],
  }
</script>
