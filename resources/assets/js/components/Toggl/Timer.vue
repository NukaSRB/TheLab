<template>
  <div>
    <nav class="panel">
      <div class="panel-block">
        <div class="columns" v-if="timer != null">
          <div class="column is-half">
            <div class="content">
              {{ timer.description }}
            </div>
            <div class="columns">
              <div class="column is-half">
                <div class="content">
                  <div id="timer-time-details">
                    <span id="hours">0</span>:<span id="minutes">00</span>:<span id="seconds">00</span></div>
                </div>
              </div>
              <div class="column is-one-quarter">
                <a :href="'/timer/stop/' + timer.id" v-if="timer">
                  <i class="fa fa-fw fa-stop"></i>
                </a>
                <i class="fa fa-fw fa-play" v-else></i>
              </div>
              <div class="column">
                <i class="fa fa-fw fa-dollar" v-if="timer.billable"></i>
                <i class="fa fa-fw fa-dollar text-grey-light" v-else></i>
              </div>
            </div>
          </div>
          <div class="column is-half">
            <ul>
              <li title="Client">C: {{ timer.client.name }}</li>
              <li title="Project">P: {{ timer.project.name }}</li>
              <li title="Task">T: {{ timer.task.name }}</li>
              <li><a href="https://www.toggl.com/app/timer" class="text-blue" target="_blank">toggl.com</a></li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <nav class="panel">
      <div class="panel-block">
        <div v-if="timer != null">
          <div class="columns">
            <div class="column">
              <div class="control">
                <input type="text" class="input" placeholder="What are you working on?" id="timer-new-description" />
              </div>
            </div>
          </div>
          <div class="columns">
            <div class="column">
              <div class="control has-addons">
                <span class="select">
                  <select>
                    <option v-for="(task, id) in orderedTasks" :value="id" v-text="task"></option>
                  </select>
                </span>
                <a href="" class="button">
                  <span class="icon">
                    <i class="fa fa-fw fa-play"></i>
                  </span>
                  <span>Start</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </div>
</template>
<style>
  #timer-new-description {
    width: 100%;
  }

  #timer-time-details {
    font-size: 2rem;
  }
</style>
<script>
  export default {
    data() {
      return {
        timer: app.timer,
        tasks: app.tasks,
      }
    },

    computed: {
      orderedTasks: function () {
        return _.orderBy(this.tasks)
      }
    },

    mounted() {
      if (this.timer != null) {
        this.upTime(this.timer.start)
      }
    },

    methods: {
      upTime(countTo)
      {
        var now        = new Date()
        var countTo    = new Date(countTo)
        var difference = (now - countTo)

        var hours = Math.floor((difference % (60 * 60 * 1000 * 24)) / (60 * 60 * 1000) * 1)
        var mins  = Math.floor(((difference % (60 * 60 * 1000 * 24)) % (60 * 60 * 1000)) / (60 * 1000) * 1)
        var secs  = Math.floor((((difference % (60 * 60 * 1000 * 24)) % (60 * 60 * 1000)) % (60 * 1000)) / 1000 * 1)

        document.getElementById('hours').firstChild.nodeValue   = this.pad(hours, 1)
        document.getElementById('minutes').firstChild.nodeValue = this.pad(mins, 2)
        document.getElementById('seconds').firstChild.nodeValue = this.pad(secs, 2)

        clearTimeout(this.upTime.to)
        this.upTime.to = setTimeout(() => { this.upTime(countTo) }, 1000)
      },

      pad(n, width, z)
      {
        z = z || '0'
        n = n + ''

        return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n
      }
    }
  }
</script>
