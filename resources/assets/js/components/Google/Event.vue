<template>
  <div>
    <div class="content">
      <h2>Today's Meetings:</h2>
    </div>
    <div v-if="events.length > 0">
      <div class="levels" style="display: flex; flex-direction: row;" v-for="eventGroup in events">
        <div class="level-item" style="flex: 1;" v-for="event in eventGroup">
          <div class="card is-fullwidth" style="max-height: 161px; height: 161px; display: flex;flex-direction: column;">
            <header class="card-header is-clearfix">
              <div class="card-header-title is-pulled-left">
                {{ event.summary }}
              </div>
              <div class="card-header-title is-pulled-right has-text-right">
                <small>
                  {{ event.times }}
                </small>
              </div>
            </header>
            <div class="card-content" style="flex-grow: 1;height: 80px;overflow-y: auto;">
              <div class="content">
                {{ event.description }}
              </div>
            </div>
            <footer class="card-footer" style="min-height: 41px; height: 41px;">
              <a class="card-footer-item" :href="event.links.hangout" target="_blank">
                <span class="icon is-small">
                  <i class="fa fa-fw fa-google"></i>
                </span>
                <span>&nbsp;Hangout</span>
              </a>
              <a class="card-footer-item" :href="event.links.calendar" target="_blank">
                <span class="icon is-small">
                  <i class="fa fa-fw fa-calendar-o"></i>
                </span>
                <span>&nbsp;Calendar</span>
              </a>
            </footer>
          </div>
        </div>
      </div>
    </div>
    <div class="box" v-else>
      No Meetings Today.
    </div>
  </div>
</template>
<script>
  export default {
    data () {
      return {
        events: app.events,
      }
    }
  }
</script>
