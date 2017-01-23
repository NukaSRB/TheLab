<template>
  <table class="table">
    <thead>
      <tr>
        <th class="search-box">
          <p class="control"><input type="text" class="input flex" placeholder="Search employees" /></p>
        </th>
        <th class="is-week" v-for="week in days.weeks">
          <strong>{{ week.name }}</strong>
          <div class="days">
            <div class="is-day" v-for="day in week.days">
              {{ day.day }}
            </div>
          </div>
        </th>
      </tr>
    </thead>
    <tbody v-for="user in users">
      <tr>
        <td class="user">{{ user.first_name }} {{ user.last_name }}</td>
        <td class="is-week" v-for="week in days.weeks">
          <div class="days">
            <div class="is-day" v-for="day in week.days">
              {{ user.schedule.weeks[week.weekOfYear].dailyTotal[day.date] }}
            </div>
          </div>
        </td>
      </tr>
      <tr v-for="project in user.projects" v-show="showForUser(user.id)">
        <td class="project">
          <small>{{ project.client.label }}</small>
          <br />
          <strong>{{ project.label }}</strong>
        </td>
        <td class="is-week" v-for="week in user.schedule.weeks">
          <div class="days">
            <div class="is-day" v-for="day in week.days">
              {{ day.schedule[project.id].hours }}
            </div>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</template>
<style>
  .search-box {
    flex:         1;
    border-top:   1px solid lightGrey;
    border-right: 1px solid lightGrey;
    padding:      0 !important;
  }

  .search-box .input {
    height:       50px;
    border:       none;
    border-right: 1px solid lightGrey !important;
  }

  .is-week {
    flex:         1;
    text-align:   center !important;
    border-right: 1px solid lightGrey;
    padding:      0 !important;
    height:       42px;
  }

  .schedule-row.header .is-week {
    border-top: 2px solid purple;
  }

  .is-week .days {
    display:        flex;
    flex-direction: row;
  }

  .user {
    padding:      0 10px 0 0 !important;
    border-right: 1px solid lightGrey !important;
  }

  .project {
    text-align:   right;
    padding:      0 10px 0 0 !important;
    border-right: 1px solid lightGrey !important;
  }

  .is-day {
    flex:         1;
    border-right: 1px solid lightGrey;
    text-align:   center;
  }

  th.is-week .is-day {
    height: 28px;
  }

  td.is-week .is-day {
    height: 42px;
  }
</style>
<script>
  export default {
    data() {
      return {
        users:           app.users,
        days:            app.availableDays,
        showUserDetails: [],
      }
    },

    methods: {
      shouldShowForUser(id) {
        if (this.showUserDetails[id] === true) {
          return true
        }

        return false
      },

      showForUser(id) {
        this.showUserDetails[id] = true
      },

      hideForUser(id) {
        this.showUserDetails[id] = false
      }
    }
  }
</script>
