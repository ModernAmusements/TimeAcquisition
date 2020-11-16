<template>
    <div>
        <label><b>Select Date</b></label>
        <date-picker :showInline=!this.isMobileView />
    </div>
</template>

<script>
import DatePickerComponent from './DatePickerComponent.vue';
export default {
         components: {
          'date-picker': DatePickerComponent
         },

         data() {
             return {
                 isMobileView: this.isMobile()
             }
         },

        mounted() {
            console.log('Component mounted.')
        },
         methods: {
            isMobile() {
                if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                    console.log('mobile')
                   return true
                } else {
                    console.log('not mobile')
                    return false
                }
            }
        }


    }
</script>
