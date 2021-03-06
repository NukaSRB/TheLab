/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./global');
require('./delete-link')

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

import ProductionDashboard from './components/Dashboard/Production.vue'
import UserSchedule from './components/Schedule/User.vue'
import EditSchedule from './components/Schedule/Edit.vue'

var app = new Vue({
  el: '#app',

  components: {
    'production-dashboard': ProductionDashboard,
    'user-schedule':        UserSchedule,
    'edit-schedule':        EditSchedule,
  }
});
