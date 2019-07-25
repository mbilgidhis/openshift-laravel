<template>
    <div>
        <b-modal id="form-event-modal" ref="form-event-modal" title="Task Form" hide-footer>
            <b-form @submit="onSubmit" v-if="show">
                <input
                  v-model="form.resourceId"
                  type="hidden"
                  name="resourceId"
                >

              <b-form-group
                id="input-group-1"
                label="Start:"
                label-for="input-1"
              >
                <b-form-input
                  id="task_name"
                  v-model="form.start"
                  type="text"
                  required
                  placeholder="Start"
                ></b-form-input>
              </b-form-group>

              <b-form-group
                id="input-group-1"
                label="End:"
                label-for="input-1"
              >
                <b-form-input
                  id="task_name"
                  v-model="form.end"
                  type="text"
                  required
                  placeholder="End"
                ></b-form-input>
              </b-form-group>

              <b-form-group
                id="input-group-1"
                label="Task Name:"
                label-for="input-1"
              >
                <b-form-input
                  id="task_name"
                  v-model="form.title"
                  type="text"
                  required
                  placeholder="Task Name"
                ></b-form-input>
              </b-form-group>

              <b-form-group id="input-group-2" label="Task Type:" label-for="input-2">
                <b-form-input
                  id="input-2"
                  v-model="form.task_type"
                  required
                  placeholder="Task Type"
                ></b-form-input>
              </b-form-group>

              <b-form-group id="input-group-3" label="Project Code:" label-for="input-3">
                <b-form-input
                  id="input-3"
                  v-model="form.project_code"
                  required
                  placeholder="Project Code"
                ></b-form-input>
              </b-form-group>

              <b-form-group id="input-group-4" label="Project Name:" label-for="input-4">
                <b-form-input
                  id="input-4"
                  v-model="form.project_name"
                  required
                  placeholder="Project Name"
                ></b-form-input>
              </b-form-group>

              <b-form-group id="input-group-5" label="Customer Site:" label-for="input-5">
                <b-form-input
                  id="input-5"
                  v-model="form.customer_site"
                  required
                  placeholder="Customer Site"
                ></b-form-input>
              </b-form-group>

              <b-form-group id="input-group-6" label="Project Manager:" label-for="input-6">
                <b-form-input
                  id="input-6"
                  v-model="form.project_manager"
                  required
                  placeholder="Project Manager"
                ></b-form-input>
              </b-form-group>

              <b-form-group id="input-group-7" label="Regular Hours:" label-for="input-7">
                <b-form-input
                  id="input-7"
                  v-model="form.regular_hours"
                  required
                  placeholder="Regular Hours"
                ></b-form-input>
              </b-form-group>

              <b-form-group id="input-group-7" label="Overtime:" label-for="input-8">
                <b-form-input
                  id="input-8"
                  v-model="form.overtime"
                  required
                  placeholder="Overtime"
                ></b-form-input>
              </b-form-group>

              <b-button type="submit" variant="primary">Submit</b-button>
            </b-form>
        </b-modal>
    </div>
</template>
<script>
import { EventBus } from '../../event-bus.js';
    export default {
        data() {
            return {
                form: {
                    resourceId: '',
                    startStr: '',
                    endStr: '',
                    title: '',
                    date: '',
                    task_name: '',
                    task_type: '',
                    project_code: '',
                    project_name: '',
                    customer_site: '',
                    project_manager: '',
                    regular_hours: '',
                    overtime: ''
                },
                show: true
            }
        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault()
                this.$emit('add-event', this.form);
                this.toggleModal();
                // alert(JSON.stringify(this.form))
            },
            toggleModal(args) {
                if(args) {
                    this.form.resourceId = args.resource.id;
                    this.form.title = args.resource.title;
                    this.form.start = args.startStr;
                    this.form.end = args.endStr;
                }
                this.$refs['form-event-modal'].toggle('#toggle-btn')
            }
        },
        mounted() {
            EventBus.$on('form-event-modal-toggle', this.toggleModal);
        }
    }
</script>
