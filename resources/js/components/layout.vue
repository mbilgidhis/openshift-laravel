<template>
    <b-container>
        <router-view></router-view>
        <b-row>
            <b-col>
                <!-- <calendar></calendar> -->
            </b-col>
        </b-row>
    </b-container>
</template>
<script>
    import Calendar from './calendar.vue'
    export default {
        components: {
            Calendar
        }
    }
</script>
