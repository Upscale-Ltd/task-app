<template>
    <li class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6">
        <div class="flex min-w-0 gap-x-4">
            <div class="relative flex items-start">
                <Switch
                    as="button"
                    :checked="task.is_completed"
                    @change="toggleComplete"
                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    :class="task.is_completed ? 'bg-green-500' : 'bg-red-500'"
                    @click="toggleComplete"
                >
                    <span class="sr-only">Mark task as completed</span>
                    <span
                        class="inline-block h-4 w-4 transform bg-white rounded-full transition-transform"
                        :class="task.is_completed ? 'translate-x-6' : 'translate-x-1'"
                    />
                </Switch>
                <div class="ml-3 text-sm leading-6">
                    <label for="task" class="font-medium text-gray-900">
                        {{ task.description }}
                    </label>
                </div>
            </div>
        </div>
        <div class="flex shrink-0 items-center gap-x-4">
            <div v-if="task.deadline" class="hidden sm:flex sm:items-center text-gray-400/75">
                <CalendarIcon />
                <p class="text-sm leading-6 text-gray-900">
                    {{ formattedDeadline }}
                </p>
            </div>
        </div>
    </li>
</template>

<script>
import { Switch } from '@headlessui/vue';
import dayjs from 'dayjs';
import CalendarIcon from '@/Components/icons/CalendarIcon.vue';

export default {
    props: {
        task: {
            type: Object,
            required: true,
        },
    },
    computed: {
        formattedDeadline() {
            return dayjs(this.task.deadline).format('YYYY-MM-DD');
        }
    },
    methods: {
        toggleComplete() {
            this.$emit('toggle-complete', this.task.id, !this.task.is_completed);
        }
    },
    components: {
        Switch,
        CalendarIcon
    }
};
</script>
