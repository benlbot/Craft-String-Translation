<template>
  <div>
    <div class="text-center" v-if="loadingTranslations">
      <div class="spinner big"></div>
    </div>

    <table class="data fullwidth" v-if="translations.length">
      <thead>
        <tr>
          <th>Key</th>
          <th>Translation</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(translation, index) in translations" :key="index">
          <td class="font-bold">{{ translation[0] }}</td>
          <td>{{ translation[1] }}</td>
        </tr>
      </tbody>
    </table>

    <div class="mt-4" v-if="( !loadingTranslations && !translations.length )">
      <p class="text-center font-bold text-lg">No translations found!</p>
    </div>

    <translation-modal :modal-content="modalContent"></translation-modal>
  </div>
</template>

<script>
import axios from 'axios';
import TranslationModal from './TranslationModal';

export default {
  components: {
    TranslationModal,
  },

  props: {
    translations: Array,
    loadingTranslations: Boolean,
  },

  data () {
    return {
      modalContent: null,
    };
  },
}
</script>
