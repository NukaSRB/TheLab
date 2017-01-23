<template>
  <div id="timer-box">
    <nav class="panel" v-if="timer != null">
      <div class="panel-heading is-clearfix">
        <div class="is-pulled-left">
          {{ timer.description }}
        </div>
        <div class="is-pulled-right">
          <a href="https://www.toggl.com/app/timer"
             class="button is-dark is-outlined is-small"
             target="_blank"
          >
            <span class="icon is-small">
              <i class="fa fa-power-off"></i>
            </span>
          </a>
        </div>
      </div>
      <div class="panel-block is-block">
        <div class="columns">
          <div class="column is-half">
            <div class="columns">
              <div class="column">
                <div class="content">
                  <div class="level">
                    <div class="level-item">
                      <div id="timer-time-details">
                        <span id="hours">0</span>:<span id="minutes">00</span>:<span id="seconds">00</span>
                      </div>
                    </div>
                  </div>
                  <div class="level">
                    <div class="level-item">
                      <a @click.prevent="stopTimer()" class="button is-small" :class="{ 'is-loading is-disabled': callingAPI }">
                        <span class="icon is-small">
                          <i class="fa fa-stop"></i>
                        </span>
                      </a>
                    </div>
                    <div class="level-item">
                      <a @click.prevent="deleteTimer()" class="button is-small" :class="{ 'is-loading is-disabled': callingAPI }">
                        <span class="icon is-small">
                          <i class="fa fa-trash"></i>
                        </span>
                      </a>
                    </div>
                    <div class="level-item">
                      <a class="button is-small" :class="{ 'is-loading is-disabled': callingAPI }">
                        <span class="icon is-small">
                          <i class="fa fa-dollar" v-if="timer.billable" @click="updateTimer({billable: false})"></i>
                          <i class="fa fa-dollar text-grey-light" v-else @click="updateTimer({billable: true})"></i>
                        </span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="column is-half">
            <ul>
              <li title="Client">C: {{ timer.client.label }}</li>
              <li title="Project">P: {{ timer.project.label }}</li>
              <li class="truncate" title="Task">T: {{ timer.task.label }}</li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <nav class="panel" v-if="timer == null">
      <div class="panel-block is-block">
        <div class="columns">
          <div class="column">
            <div class="control">
              <input type="text" v-model="form.description" class="input" placeholder="What are you working on?" id="timer-new-description" />
            </div>
          </div>
        </div>
        <div class="columns">
          <div class="column">
            <p class="control has-addons">
              <select id="task-select" placeholder="Select a task" v-model="form.task_id"></select>
              <a @click.prevent="startTimer()" class="button">
                  <span class="icon">
                    <i class="fa fa-fw fa-play"></i>
                  </span>
                <span>Start</span>
              </a>
            </p>
          </div>
        </div>
      </div>
      <div class="panel-block is-block" v-for="task in previousTasks">
        <div class="columns">
          <div class="column">
            <div class="is-pulled-left">
              <strong>{{ task.description }}</strong>
            </div>
            <div class="is-pulled-right">
              <a @click.prevent="continueTimer(task.task.id, task.description)" class="button">
                <span class="icon">
                  <i class="fa fa-fw fa-play"></i>
                </span>
              </a>
            </div>
            <br />
            <small class="text-grey">
              {{ task.client.abbreviation }} -
              {{ task.project.label }} -
              {{ task.task.label }}
            </small>
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

  #timer-box {
    margin-top: 10px;
  }

  #timer-box .level {
    margin-bottom: 0;
  }

  .selectize-control {
    flex:   1;
    height: 2.5em;
  }

  .selectize-input {
    height:                     2.7em;
    border-top-right-radius:    0;
    border-bottom-right-radius: 0;
  }

  .truncate {
    width:         200px;
    white-space:   nowrap;
    overflow:      hidden;
    text-overflow: ellipsis;
  }
</style>
<script>
  export default {
    data() {
      return {
        previousTasks: app.previousTasks,
        timer:         app.timer,
        tasks:         app.tasks,
        callingAPI:    false,
        form:          {
          _token:      Laravel.csrfToken,
          task_id:     null,
          description: null,
        }
      }
    },

    computed: {
      orderedTasks() {
        if (typeof this.tasks != 'undefined') {
          return _.orderBy(this.tasks, 'name')
        }
      }
    },

    mounted() {
      if (this.timer != null) {
        this.upTime(this.timer.start)
      } else {
        this.setSelectize()
      }
    },

    updated() {
      if (this.timer != null) {
        this.upTime(this.timer.start)
      } else {
        this.setSelectize()
      }
    },

    methods: {
      setSelectize() {
        $('#task-select').selectize({
          allowEmptyOption: false,
          options:          this.orderedTasks,
          valueField:       'id',
          labelField:       'name',
          searchField:      [
            'id',
            'name'
          ],
          onItemAdd:        (value, item) =>
                            {
                              this.form.task_id = value
                            }
        })
      },

      upTime(countTo) {
        if (document.getElementById('hours') != null) {
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
        }
      },

      pad(n, width, z) {
        z = z || '0'
        n = n + ''

        return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n
      },

      continueTimer(taskId, description)
      {
        this.form.task_id     = taskId
        this.form.description = description

        this.startTimer()
      },

      startTimer() {
        if (this.callingAPI === true) {
          return false
        }

        this.callingAPI = true

        this.$http.post('/timer/start', this.form)
            .then((response) =>
            {
              $('#task-select')[0].selectize.destroy();

              this.timer = response.body

              this.callingAPI = false
            }, (error) =>
            {
              this.callingAPI = false
            })
      }
    },

    stopTimer() {
      if (this.callingAPI === true) {
        return false
      }

      this.callingAPI = true

      this.$http.post('/timer/stop/' + this.timer.id, this.form)
          .then((response) =>
          {
            this.timer = null

            this.resetTimerFields()
            this.callingAPI = false
          }, (error) =>
          {
            this.callingAPI = false
          })
    },

    deleteTimer() {
      if (this.callingAPI === true) {
        return false
      }

      this.callingAPI = true

      this.$http.post('/timer/delete/' + this.timer.id, this.form)
          .then((response) =>
          {
            this.timer = null

            this.resetTimerFields()
            this.callingAPI = false
          }, (error) =>
          {
            this.callingAPI = false
          })
    },

    updateTimer(options) {
      if (this.callingAPI === true) {
        return false
      }

      this.callingAPI = true

      options._token = Laravel.csrfToken

      this.$http.post('/timer/update/' + this.timer.id, options)
          .then((response) =>
          {
            this.timer = response.body

            this.callingAPI = false
          }, (error) =>
          {
            this.callingAPI = false
          })
    },

    resetTimerFields()
    {
      this.form.task_id     = null
      this.form.description = null
    }
  }
</script>
