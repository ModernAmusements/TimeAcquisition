<template>
  <div>
       <flat-pickr v-model="date"
                :config="config"
                class="form-control"
                placeholder="Select time"
                name="start_time"
                id="start_time"
                style="padding-right: 260px;"
                />
  </div>
</template>

<script>
  import flatPickr from 'vue-flatpickr-component';
  import 'flatpickr/dist/flatpickr.css';

  export default {
    mounted() {
        console.log('Component mounted.')
        },
      data () {
      return {
        date: null,
        config: {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: false
        }
      }
    },
    components: {
      flatPickr
    }
  }
</script>
