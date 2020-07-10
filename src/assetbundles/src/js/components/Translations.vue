<template>
  <div>
    <translations-filter
      @filter-translations="filterTranslations"
    >
    </translations-filter>

    <translations-table
      :translations="translations"
      :loading-translations="loadingTranslations"
      @translation-updated="onTranslationUpdate()"
    >
    </translations-table>
  </div>
</template>

<script>
import axios from 'axios';
import TranslationsTable from './TranslationsTable';
import TranslationsFilter from './TranslationsFilter';

export default {
  components: {
    TranslationsTable,
    TranslationsFilter,
  },

  data() {
    return {
      translations: [],

      loadingTranslations: true,
    };
  },

  mounted() {
    this.loadTranslations();
  },

  methods: {
    loadTranslations (param) {
      this.translations = [];
      axios.get('/actions/string-translation/default/get-translations', {translation : param})
      .then((response) => {
        this.translations = Object.entries(response.data);
        this.loadingTranslations = false;
      })
      .catch((error) => {
        Craft.cp.displayError("Failed to load the translations");
        this.loadingTranslations = false;
      });
    },

    onTranslationUpdate () {
      this.loadTranslations();
    },

    filterTranslations (filter) {
      console.log("filterTranslations :" + filter);
      if ( filter !== "" ) {
        this.loadTranslations(filter);
      }
    }
  }
}
</script>

