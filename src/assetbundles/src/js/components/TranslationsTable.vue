<template>
  <div>
    <div class="text-center" v-if="loadingTranslations">
      <div class="spinner big"></div>
    </div>

    <form class="flex justify-end" id="st_form" @submit="confirmUpdate">

      <table class="data fullwidth widefat striped" v-if="translations.length">
        <thead>
          <tr>
            <th class="column-string">Key</th>
            <th class="column-translations">Translation</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(translation, index) in translations" :key="index">
            <td class="font-bold column-string">{{ translation[0] }}</td>
            <td class="column-translations">
              <div class="translation" v-for="(langValue, lang) in translation[1]" :key="lang">
                <label :for="`${lang}-${translation[0]}`">{{lang}}</label>
                <input type="text" v-model="translations[index][1][lang]" :id="`${lang}-${translation[0]}`"></input>
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <button class="btn submit">Save Changes</button>
    </form>
    <div class="mt-4" v-if="( !loadingTranslations && !translations.length )">
      <p class="text-center font-bold text-lg">No translations found!</p>
    </div>

  </div>
</template>

<script>
import axios from 'axios';
//:value="`${langValue}`"
export default {

  props: {
    translations: Array,
    loadingTranslations: Boolean,
  },

  methods: {
    confirmUpdate (e) {
      e.preventDefault();
      this.$swal({
        title: 'Are you sure?',
        html: "All fields will be updated. You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#a2a2a2',
        confirmButtonText: 'Yes, Update!'
      }).then((result) => {
        if (result.value) {
          this.updateTranslation(e);
        }
      });
    },

    updateTranslation (e) {
      let headers = {
        'X-CSRF-Token': Craft.csrfTokenValue,
      };

      let data = JSON.stringify(this.translations);

      axios.post('/actions/string-translation/default/update-translations', data, {'headers': headers})
      .then((response) => {
        Craft.cp.displayNotice("Translations updated");
      })
      .catch((error) => {
        Craft.cp.displayError("Failed to update translations");
      });
    },

  },

}
</script>
