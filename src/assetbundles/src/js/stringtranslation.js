import Vue from 'vue';
import Vuex from 'vuex'
import Moment from 'vue-moment';
import VueSweetalert2 from 'vue-sweetalert2';
import VTranslations from './components/Translations.vue';

Vue.use(Vuex);
Vue.use(Moment);
Vue.use(VueSweetalert2);

import store from './store';

const vm = new Vue({
  el: '#string-translation-app',
  store,
  delimiters: ["<%","%>"],
  components: {
    'v-translations': VTranslations,
  },
});