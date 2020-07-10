<template>
  <div class="mb-6">
    <form class="flex justify-end" @submit.prevent="filterTranslations()">
      <div>
        <span class="status" :class="{'on': filterActive}" title="Filter status"></span>
      </div>

      <div>
        <label class="hidden">Translation</label>
        <div>
          <input class="text" type="text" name="translation" placeholder="Search by Translation" v-model="filter" />
        </div>
      </div>

      <div>
        <button class="btn submit">Search Translations</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data () {
    return {
      filter: "",
      filterActive: false,
    };
  },

  mounted () {
    this.filter = "";
  },

  methods: {
    filterTranslations () {
      if ( !this.isEmptyObject(this.filter)  ) {
        this.filterActive = true;
        this.$emit('filter-translation', this.filter);
      } else {
        this.filter = "";
        this.filterActive = false;
        this.$emit('filter-translation', this.filter);
      }
    },

    isEmptyObject (object) {
      return Object.keys(object).every(function(x) {
          return object[x]===''||object[x]===null;
      });
    },

  },
}
</script>