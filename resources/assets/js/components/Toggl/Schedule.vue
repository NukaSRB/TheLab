<template>
  <nav class="panel">
    <div class="panel-heading is-clearfix">
      <div class="is-pulled-left">
        {{ type }} Schedule
      </div>
      <div class="is-pulled-right">
        <a :href="summary"
           class="button is-dark is-outlined is-small"
           target="_blank"
        >
        <span class="icon is-small">
          <i class="fa fa-bar-chart"></i>
        </span>
        </a>
      </div>
    </div>
    <div class="panel-block is-block" v-for="schedule in schedules">
      <div class="columns">
        <div class="column is-1">
          {{ schedule.client.abbreviation }}
        </div>
        <div class="column is-7">
          {{ schedule.project.label}}
          ({{ schedule.percentage }}%)
        </div>
        <div class="column is-2">{{ schedule.time }}hrs</div>
        <div class="column is-2">{{ schedule.hours }}hrs</div>
      </div>
      <div class="columns">
        <div class="column">
          <progress class="progress"
                    :class="schedule.project.name"
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
    data() {
      return {
        toggl: app.toggl,
      }
    },

    computed: {
      summary() {
        if (this.type === 'Daily') {
          return 'https://www.toggl.com/app/reports/summary/901085/period/today/users/' + this.toggl.social_id + '/billable/both';
        }

        return 'https://www.toggl.com/app/reports/summary/901085/period/thisWeek/users/' + this.toggl.social_id + '/billable/both';
      },
    },

    props: [
      'type',
      'schedules'
    ],
  }
</script>
