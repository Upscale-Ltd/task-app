<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tasks</h2>

                <PrimaryButton @click="showModal = true">Create Task</PrimaryButton>
            </div>
        </template>

        <div class="max-w-2xl mx-auto py-12">
            <div class="flex justify-end mb-4 space-x-2">
                <SortButton
                    label="Sort by Deadline"
                    value="deadline"
                    :activeSort="sortOrder"
                    @update-sort="setSortOrder"
                />
                <SortButton
                    label="Sort by Creation Date"
                    value="created_at"
                    :activeSort="sortOrder"
                    @update-sort="setSortOrder"
                />
                <button
                    @click="toggleSortDirection"
                    :class="['px-4 py-2 rounded', sortDirection === 'asc' ? 'bg-blue-500 text-white' : 'bg-gray-200']"
                >
                    {{ sortDirection === 'asc' ? 'Ascending' : 'Descending' }}
                </button>
            </div>
            <ul role="list" class="divide-y divide-gray-100 overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                <Task
                    v-for="task in sortedTasks"
                    :key="task.id"
                    :task="task"
                    @toggle-complete="toggleComplete"
                />
            </ul>
        </div>

        <CreateTaskModal :show="showModal" @save-task="addTask" @close="showModal = false" />
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Task from '@/Components/Task.vue';
import CreateTaskModal from '@/Components/CreateTaskModal.vue';
import SortButton from '@/Components/SortButton.vue';
import { useToast } from 'vue-toastification';
import axios from '../axios';

export default {
    components: {
        AuthenticatedLayout,
        Head,
        PrimaryButton,
        Task,
        CreateTaskModal,
        SortButton,
    },
    setup() {
        const toast = useToast();
        return { toast };
    },
    data() {
        return {
            tasks: [],
            showModal: false,
            sortOrder: 'deadline',
            sortDirection: 'asc',
        };
    },

    computed: {
        sortedTasks() {
            return this.tasks.slice().sort((a, b) => {
                let comparison;
                if (this.sortOrder === 'deadline') {
                    comparison = new Date(a.deadline || a.created_at) - new Date(b.deadline || b.created_at);
                } else {
                    comparison = new Date(a.created_at) - new Date(b.created_at);
                }
                return this.sortDirection === 'asc' ? comparison : -comparison;
            });
        },
    },

    methods: {
        addTask(task) {
            this.tasks.push(task);
            this.showModal = false;
        },
        fetchTasks() {
            axios.get(route('tasks.index'))
                .then(response => {
                    this.tasks = response.data.data;
                })
                .catch(error => {
                    console.error('There was an error fetching the tasks:', error);
                });
        },
        setSortOrder(order) {
            this.sortOrder = order;
        },
        toggleSortDirection() {
            this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
        },
        toggleComplete(taskId, isCompleted) {
            axios.patch(route('tasks.update', { task: taskId }), { is_completed: isCompleted })
                .then(response => {
                    const index = this.tasks.findIndex(task => task.id === taskId);
                    if (index !== -1) {
                        this.tasks[index] = response.data.data;
                        this.toast.success(`Task marked as ${isCompleted ? 'completed' : 'incomplete'}`);
                    }
                })
                .catch(error => {
                    console.error('There was an error updating the task status:', error);
                    this.toast.error('Failed to update task status');
                });
        },
    },

    mounted() {
        this.fetchTasks();
    },
};
</script>
