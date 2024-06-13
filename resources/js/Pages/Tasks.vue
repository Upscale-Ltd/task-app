<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Task from '@/Components/Task.vue';

export default {
    components: {
        AuthenticatedLayout,
        Head,
        PrimaryButton,
        Task,
    },

    data() {
        return {
            tasks: [
                {
                    id: 1,
                    label: 'My Task',
                    deadline: '20th July 2024',}
            ],
            showModal: false,
        };
    },
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tasks</h2>

                <PrimaryButton @click="showModal = !showModal">Create Task</PrimaryButton>
            </div>
        </template>

        <div class="max-w-2xl mx-auto py-12">
            <ul role="list" class="divide-y divide-gray-100 overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                <Task v-for="task in tasks" :key="task.id" :task="task" />
            </ul>
        </div>
    </AuthenticatedLayout>
</template>
