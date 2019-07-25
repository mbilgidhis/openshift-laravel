<template>
  <div class='calendar'>
    <form-resource-modal @add-resource="addResource"></form-resource-modal>
    <form-event-modal @add-event="addEvent"></form-event-modal>
    <b-input-group>
        <datetime input-ref="datepicker" v-model="date" input-class="form-control" placeholder="Choose Date ..."></datetime>
        <b-input-group-append>
            <b-button variant="info"><span class="fa fa-calendar-alt"></span></b-button>
        </b-input-group-append>
    </b-input-group>
    <div class="text-right">
        <b-button-group>
            <b-button variant="primary" @click="formResourceModalToggle"><span class="fa fa-plus"></span></b-button>
            <b-button variant="success"><span class="fa fa-file-excel"></span></b-button>
        </b-button-group>
    </div>
    <FullCalendar
        class='calendar-container'
        ref="fullCalendar"
        defaultView="resourceTimelineWeek"
        :header="{
        left: 'prev,next today',
        center: 'title',
        right: ''
        }"
        :plugins="calendarPlugins"
        :weekends="calendarWeekends"
        :events="events"
        @select="formEventModalToggle"
        @eventClick="eventClick"
        :resourceColumns="resourceColumns"
        :resources="resources"
        :selectable="selectable"
        :height="height"
    />
  </div>
</template>

<script>
import FullCalendar from '@fullcalendar/vue'
import resourceTimelinePlugin from '@fullcalendar/resource-timeline'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import FormResourceModal from './form/FormResourceModal.vue'
import FormEventModal from './form/FormEventModal.vue'
import { EventBus } from '../event-bus.js';


export default {
  components: {
    FullCalendar, // make the <FullCalendar> tag available
    FormResourceModal,
    FormEventModal
  },
  data: function() {
    return {
        date: '',
        calendarPlugins: [ // plugins must be defined in the JS
            resourceTimelinePlugin,
            timeGridPlugin,
            interactionPlugin // needed for dateClick
        ],
        calendarWeekends: true,
        selectable: true,
        calendarEvents: [ // initial event data
            { title: 'Event Now', start: new Date() }
        ],
        resourceColumns: [
            {
                labelText: 'Task Name',
                field: 'title'
            },
            {
                labelText: '#',
                field: 'menu',
                width: 70,
                render: function(resource, el) {
                    var extendedProps = resource.extendedProps;
                    console.log(el);
                    var menu = `
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-danger"><span class="fa fa-trash"></span></button>
                            <button type="button" class="btn btn-warning"><span class="fa fa-edit"></span></button>
                        </div>
                    `;
                    $(el).html(menu);
                }
            },
        ],
        events: [],
        resources: [],
        height: 500
    }
  },
    methods: {
        formResourceModalToggle(args) {
            EventBus.$emit('form-resource-modal-toggle');
        },
        formEventModalToggle(args) {
            EventBus.$emit('form-event-modal-toggle', args);
        },
        addResource(args) {
            var that = this;
            this.$http.post('/plan', {
                id: args.id,
                title: args.title
            }).then((response) => {
                that.resources.push({
                    id: args.id,
                    title: args.title,
                });
                console.log(response);
            }).catch((error) => {
                console.log(error);
            });
        },
        addEvent(args) {
            var that = this;
            this.$http.post('/plan_event', {
                resourceId: args.resourceId,
                title: args.title,
                start: args.start,
                end: args.end
            }).then((response) => {
                that.events.push({
                    resourceId: args.resourceId,
                    title: args.title,
                    start: args.start,
                    end: args.end
                });
                console.log(response);
            }).catch((error) => {
                console.log(error);
            });
            console.log(this.events);
        },
        eventClick(data) {
            console.log(data);
        }
    },
    mounted() {
        var that = this;
        this.$http.get('/plan').then((result) => {
            console.log(result);
            result.data.data.forEach((data) => {
                that.resources.push({
                    id: data.resourceId,
                    title: data.title,  
                    menu: 'garda'       
                });
            });
        });
        this.$http.get('/plan_event').then((result) => {
            console.log(result);
            result.data.data.forEach((data) => {
                that.events.push({
                    resourceId: data.resourceId,
                    title: data.title,
                    start: data.start,
                    end: data.end       
                });
            });
        });
    }
}

</script>

<style lang='scss'>

// you must include each plugins' css
// paths prefixed with ~ signify node_modules
@import '~@fullcalendar/core/main.css';
@import '~@fullcalendar/timeline/main.css';
@import '~@fullcalendar/resource-timeline/main.css';
@import '~@fullcalendar/daygrid/main.css';
@import '~@fullcalendar/timegrid/main.css';

.calendar {
  font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
  font-size: 14px;
}

.calendar-top {
  margsin: 0 0 3em;
}

.calendar-container {
  margsin: 0 auto;
  margsin-top: 10px;
  width: 100%;
}

</style>
