<template>
  <div class="box">
    <form method="POST">
      <input type="hidden" name="_token" :value="csrfToken" />
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
        <div class="row" v-for="(schedule, project_id) in schedules">
          <div class="col-sm-2">
            <small class="text-muted">{{ getFirstEntry(schedule).project.client.label }}</small>
            <br />
            <strong>{{ getFirstEntry(schedule).project.label }}</strong>
          </div>
          <div class="col-sm-2" v-for="date in dates">
            <div class="input-group">
              <input type="hidden" :name="'hours['+ project_id +']['+ date.long +'][id]'" v-model="form[project_id][date.long].id" />
              <input :name="'hours['+ project_id +']['+ date.long +'][hours]'" type="text" class="form-control"
                     @keyup="getSums()"
                     :data-date="date.class"
                     v-model="form[project_id][date.long].hours"
              />
              <input type="hidden" :name="'hours['+ project_id +']['+ date.long +'][note]'" v-model="form[project_id][date.long].note" />
              <span class="input-group-btn" title="Add Note">
                <button href="" class="btn btn-primary" style="background-color: #544360;border-radius: 0;" @click.prevent="launchModal(project_id, date.long)">
                  <i class="fa fa-fw fa-sticky-note-o" v-if="form[project_id][date.long].note == null"></i>
                  <i class="fa fa-fw fa-sticky-note" v-if="form[project_id][date.long].note != null"></i>
                </button>
              </span>
              <span class="input-group-addon" title="Repeat Weekly" style="background-color: #544360;border-color: #544360;">
                <input :name="'hours['+ project_id +']['+ date.long +'][repeat]'" type="checkbox" aria-label="..."
                       v-model="form[project_id][date.long].repeat"
                />
              </span>
            </div>
          </div>
          <hr />
        </div>
        <div class="row">
          <div class="col-md-2">&nbsp;</div>
          <div class="col-md-2" v-for="sum in sums">
            <div class="btn btn-block" :class="{'btn-danger': sum > 8, 'btn-success': sum <= 8}" :style="{opacity: sum < 8 ? '.5' : '1'}">
              {{ sum }}
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <div class="form-group">
          <div class="col-sm-2">
            <input type="submit" value="Save" class="btn btn-primary" />
          </div>
          <div class="col-sm-5">&nbsp;</div>
          <div class="col-sm-4">
            <select id="project-select" placeholder="Add a project"></select>
          </div>
          <div class="col-sm-1">
            <button class="btn btn-primary" @click.prevent="addProject()">Add Project</button>
          </div>
        </div>
      </div>
    </form>
    <div class="modal fade" tabindex="-1" role="dialog" id="noteModal" aria-labelledby="noteModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" @click.prevent="closeModal()" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="noteModalLabel">Add Note</h4>
          </div>
          <div class="modal-body">
            <textarea v-model="modal.note" id="noteModalInput" class="form-control" cols="30" rows="5"></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" @click.prevent="closeModal()">Close</button>
            <button type="button" class="btn btn-primary" @click.prevent="saveNote()">Save note</button>
          </div>
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
        csrfToken:    Laravel.csrfToken,
        user:         app.user,
        projects:     app.projects,
        dates:        app.dates,
        schedules:    app.schedules,
        counts:       {},
        selectize:    null,
        sums:         [],
        form:         app.form,
        newProjectId: null,
        modal:        {
          projectId: null,
          date:      null,
          note:      null,
        }
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
                              this.newProjectId = value
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

      launchModal(projectId, date) {
        this.modal.projectId = projectId
        this.modal.date      = date
        this.modal.note      = this.form[projectId][date].note

        $('#noteModal').modal('show')

        $('#noteModalInput').focus()
      },

      closeModal() {
        this.modal.projectId = null
        this.modal.date      = null
        this.modal.note      = null

        $('#noteModal').modal('hide')
      },

      saveNote() {
        this.form[this.modal.projectId][this.modal.date].note = this.modal.note

        this.modal.projectId = null
        this.modal.date      = null
        this.modal.note      = null

        $('#noteModal').modal('hide')
      },

      addProject() {
        this.$http.get('/admin/schedule/new-project/' + this.newProjectId + '/' + this.dates[0].long)
            .then((response) =>
            {
              let body = response.body

              this.form      = Object.assign({}, this.form, body.form)
              this.schedules = Object.assign({}, this.schedules, body.schedule)
            })
        // get project details from the back end
        // add project to form
        // add project to projects
        // add project to schedule
      }
    }
  }
</script>
