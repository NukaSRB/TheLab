<template>
  <div class="box">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.4/css/selectize.bootstrap3.min.css" />
    <div class="box-header with-border">
      <h3 class="box-title">
        {{ user.first_name }} {{ user.last_name }}
        Schedule for {{ dates[0].short }}
        through {{ dates[4].short }}
      </h3>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-2" v-for="date in dates">{{ date.short }}</div>
      </div>
      <form>
        <div class="row" v-for="(schedule, project_id) in schedules">
          <div class="col-sm-2">
            <small class="text-muted">{{ getFirstEntry(schedule).project.client.label }}</small>
            <br />
            <strong>{{ getFirstEntry(schedule).project.label }}</strong>
          </div>
          <div class="col-sm-2" v-for="date in dates">
            <div class="input-group">
              <input :name="'hours['+ project_id +']['+ date.long +'][hours]'" type="text" class="form-control"
                     @change="getSums()"
                     :data-date="date.class"
                     v-model="form[project_id][date.long]"
              />
              <span class="input-group-btn" title="Add Note">
                <button href="" class="btn btn-primary" style="background-color: #544360;border-radius: 0;">
                  <i class="fa fa-fw fa-sticky-note-o"></i>
                </button>
              </span>
              <span class="input-group-addon" title="Repeat Weekly" style="background-color: #544360;border-color: #544360;">
                <input name="hours['+ project_id +']['+ date.long +'][repeat]'" type="checkbox" aria-label="...">
              </span>
            </div>
          </div>
          <hr />
        </div>
        <div class="row">
          <div class="col-md-2">&nbsp;</div>
          <div class="col-md-2" v-for="sum in sums">
            <div class="btn btn-block" :class="{'btn-danger': sum > 8, 'btn-success': sum == 8}">
              {{ sum }}
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="box-footer">
      <div class="form-group">
        <div class="col-sm-2">
          <input type="submit" value="Save" class="btn btn-primary" />
        </div>
        <div class="col-sm-5">&nbsp;</div>
        <div class="col-sm-4">
          <select id="project-select" placeholder="Add a project" v-model="new_project_id"></select>
        </div>
        <div class="col-sm-1">
          <button class="btn btn-primary">Add Project</button>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
  .selectize-control {
    flex:   1;
    height: 2.5em;
  }

  .selectize-input {
    height:                     2.7em;
    border-top-right-radius:    0;
    border-bottom-right-radius: 0;
  }
</style>
<script>
  export default {
    data() {
      return {
        user:      app.user,
        projects:  app.projects,
        dates:     app.dates,
        schedules: app.schedules,
        counts:    {},
        selectize: null,
        sums:      [],
        form:      app.form,
      }
    },

    computed: {
      orderedProjects() {
        return _.orderBy(this.projects, 'clientAndLabel')
      }
    },

    mounted() {
      this.setSelectize()

      this.getSums()
    },

    methods: {
      setSelectize() {
        this.selectize = $('#project-select').selectize({
          allowEmptyOption: false,
          options:          this.orderedProjects,
          valueField:       'id',
          labelField:       'clientAndLabel',
          searchField:      [
            'id',
            'name',
            'clientAndLabel'
          ],
          onItemAdd:        (value, item) =>
                            {
                              this.addProject(value)
                            }
        })
      },

      getSums() {
        this.sums = this.dates.map((date, index) =>
        {
          let sum = 0

          $('[data-date="' + date.class + '"]').each(function ()
          {
            let value = parseFloat($(this).val())

            if (!isNaN(value)) {
              sum += value
            }
          })

          return sum
        })
      },

      addProject(projectId) {
        console.log(projectId)
      },

      getFirstEntry(schedule) {
        let key = Object.keys(schedule)[0]

        return schedule[key]
      },
    }
  }
</script>
