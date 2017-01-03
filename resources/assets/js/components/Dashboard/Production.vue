<template>
  <div class="columns">
    <div class="column is-three-quarters">
      <calendar-events></calendar-events>
      <br />
      <daily-tasks></daily-tasks>
    </div>
    <div class="column is-one-quarter">
      <active-timer></active-timer>
      <scheduled-hours type="Daily" :schedules="dailySchedule"></scheduled-hours>
      <scheduled-hours type="Weekly" :schedules="weeklySchedule"></scheduled-hours>
    </div>
  </div>
</template>
<style>

</style>
<script>
  import TogglTimer from '../Toggl/Timer.vue'
  import TogglSchedule from '../Toggl/Schedule.vue'
  import GoogleEvent from '../Google/Event.vue'
  import AsanaTask from '../Asana/Task.vue'

  export default {
    data() {
      return {
        dailySchedule:  app.dailySchedule,
        weeklySchedule: app.weeklySchedule,
      }
    },
    components: {
      'active-timer':    TogglTimer,
      'scheduled-hours': TogglSchedule,
      'calendar-events': GoogleEvent,
      'daily-tasks': AsanaTask,
    }
  }
</script>
