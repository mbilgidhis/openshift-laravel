<template>
    <div>
        <b-modal id="form-resource-modal" ref="form-resource-modal" title="Task Form" hide-footer>
            <b-form @submit="onSubmit" v-if="show">

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
                  placeholder="Task Title"
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
                    title: ''
                },
                show: true
            }
        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                this.form.id =  Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
                this.$emit('add-resource', this.form);
                console.log(this.form);
                this.toggleModal();
            },
            toggleModal() {
                this.$refs['form-resource-modal'].toggle('#toggle-btn')
            }
        },
        mounted() {
            EventBus.$on('form-resource-modal-toggle', this.toggleModal);
        }
    }
</script>
