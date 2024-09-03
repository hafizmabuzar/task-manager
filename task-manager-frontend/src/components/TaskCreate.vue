<template>
    <div class="container-fluid mt-4">
        <div>
            <li v-for="(e, i) in formErrors" :key="i">{{e[0]}}</li>
        </div>
        <form @submit.prevent="submitForm">
            <div class="form-group">
                <label for="title">Title</label>
                <input
                    id="title"
                    v-model="task.title"
                    type="text"
                    class="form-control"
                    placeholder="Enter task title"
                    required
                />
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea
                    id="description"
                    v-model="task.description"
                    class="form-control"
                    placeholder="Enter task description"
                ></textarea>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select
                    id="status"
                    v-model="task.status"
                    class="form-control"
                >
                    <option value="pending">Pending</option>
                    <option value="in-progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
            <div class="form-group">
                <label for="due_date">Due Date</label>
                <input
                    id="due_date"
                    v-model="task.due_date"
                    type="date"
                    class="form-control"
                />
            </div>
            <button type="submit" class="btn btn-primary">
                {{ isEditing ? 'Update' : 'Save' }}
            </button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        taskToEdit: {
            type: Object,
            default: () => ({})
        }
    },
    data() {
        return {
            task: {
                title: '',
                description: '',
                status: 'pending',
                due_date: ''
            },
            isEditing: false,
            formErrors: []
        };
    },
    watch: {
        taskToEdit: {
            immediate: true,
            handler(newVal) {
                if (newVal && Object.keys(newVal).length) {
                    this.task = { ...newVal };
                    this.isEditing = true;
                } else {
                    this.isEditing = false;
                    this.resetForm();
                }
            }
        }
    },
    methods: {
        submitForm() {
            if (this.isEditing) {
                axios.put(`/tasks/${this.task.id}`, this.task)
                    .then(() => {
                        this.$emit('task-updated');
                        this.resetForm();
                    })
                    .catch(error => {
                        console.error('Error updating task:', error);
                    });
            } else {
                axios.post('/tasks', this.task, {
                    headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(() => {
                        this.$emit('task-updated');
                        this.resetForm();
                    })
                    .catch(error => {
                        if(error.response.data.errors !== undefined){
                            this.formErrors = error.response.data.errors;
                        }
                        console.error('Error creating task:', error);
                    });
            }
        },
        resetForm() {
            this.task = {
                title: '',
                description: '',
                status: 'pending',
                due_date: ''
            };
            this.isEditing = false;
        }
    }
};
</script>
