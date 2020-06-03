import Vue from 'vue';
import Vuex from 'vuex'
import Moment from 'vue-moment';
import VueSweetalert2 from 'vue-sweetalert2';
import VueConfetti from 'vue-confetti';
import VConfetti from './components/Confetti.vue';
import VTranslations from './components/Translations.vue';

Vue.use(Vuex);
Vue.use(Moment);
Vue.use(VueSweetalert2);
Vue.use(VueConfetti);

import store from './store';

const vm = new Vue({
  el: '#string-translation-app',
  store,
  delimiters: ["<%","%>"],
  components: {
    'v-confetti': VConfetti,
    'v-translations': VTranslations,
  },
});