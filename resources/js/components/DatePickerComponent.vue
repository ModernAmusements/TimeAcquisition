<template>
  <div>
    <flat-pickr v-model="date"
                :config="config"
                class="form-control"
                placeholder="Select date"
                name="start_day"
                />
  </div>
</template>

<script>
  import flatPickr from 'vue-flatpickr-component';
  import 'flatpickr/dist/flatpickr.css';
  export default {
    props: ['showInline'],
    mounted() {
        console.log('Component mounted.')
        },
      data () {
      return {
        date: null,
        config: {
            // mode: "range",
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
            inline: this.showInline
            // enableTime: true,
        }
      }
    },
    components: {
      flatPickr
    }
  }
</script>