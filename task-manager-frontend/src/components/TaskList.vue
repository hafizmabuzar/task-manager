<template>
    <div class="row">
        <div class="col-md-4">
            <TaskCreate :taskToEdit="currentTask" @task-updated="fetchTasks"/>
        </div>
        <div class="col-md-8">
            <table class="table table-bordered mt-4">
                <tr v-for="task in tasks" :key="task.id">
                    <td>
                        {{ task.title }}
                    </td>
                    <td>
                        {{ task.description }}
                    </td>
                    <td>
                        {{ task.status }}
                    </td>
                    <td>
                        {{ task.due_date }}
                    </td>
                    <td>
                        <button @click="editTask(task)" class="btn btn-secondary">Edit</button>
                        <button @click="deleteTask(task.id)" class="btn btn-danger ml-2">Delete</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import TaskCreate from './TaskCreate.vue';

export default {
    components: { TaskCreate },
    data() {
        return {
            tasks: [],
            currentTask: {}
        };
    },
    created() {
        this.fetchTasks();
    },
    methods: {
        fetchTasks() {
            axios.get('tasks')
                .then(response => {
                    this.tasks = response.data.tasks;
                });
        },
        deleteTask(id) {
            axios.delete(`tasks/${id}`)
                .then(() => {
                    this.fetchTasks();
                });
        },
        editTask(task) {
            this.currentTask = task;
        }
    }
};
</script>
