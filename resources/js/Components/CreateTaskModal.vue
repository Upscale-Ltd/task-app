<template>
    <TransitionRoot as="template" :show="show" @keydown.esc="closeModal">
        <Dialog as="div" class="fixed z-10 inset-0 overflow-y-auto" @close="closeModal">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <TransitionChild
                    as="template"
                    enter="ease-out duration-300"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                </TransitionChild>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <TransitionChild
                    as="template"
                    enter="ease-out duration-300"
                    enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to="opacity-100 translate-y-0 sm:scale-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100 translate-y-0 sm:scale-100"
                    leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                        <div>
                            <div class="mt-3 text-center sm:mt-5">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">
                                    Create a new Task
                                </DialogTitle>
                                <div class="mt-2">
                                    <input v-model="task.description" type="text" placeholder="Task description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    <div v-if="errors.description" class="text-red-500 text-sm mt-1 bg-red-100 p-2 rounded">
                                        {{ errors.description[0] }}
                                    </div>

                                    <input v-model="task.deadline" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    <div v-if="errors.deadline" class="text-red-500 text-sm mt-1 bg-red-100 p-2 rounded">
                                        {{ errors.deadline[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 sm:mt-6 flex justify-end space-x-2">
                            <button @click="closeModal" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-500 text-base font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:text-sm">
                                Cancel
                            </button>
                            <button @click="saveTask" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                                Save
                            </button>
                        </div>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import { Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { useToast } from 'vue-toastification';
import axios from '../axios';

export default {
    props: {
        show: {
            type: Boolean,
            default: false,
        },
    },
    setup() {
        const toast = useToast();
        return { toast };
    },
    data() {
        return {
            task: {
                description: '',
                deadline: '',
            },
            errors: {},
        };
    },
    methods: {
        saveTask() {
            axios.post(route('tasks.store'), this.task)
                .then(response => {
                    this.$emit('save-task', response.data.data);
                    this.resetForm();
                    this.toast.success('Task created successfully');
                })
                .catch(error => {
                    if (error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors;
                        this.toast.error('Failed to create task');
                    }
                });
        },
        resetForm() {
            this.task.description = '';
            this.task.deadline = '';
            this.errors = {};
            this.$emit('close');
        },
        closeModal() {
            this.resetForm();
            this.$emit('close');
        },
        handleEsc(event) {
            if (event.key === 'Escape') {
                this.closeModal();
            }
        }
    },
    watch: {
        show(value) {
            if (value) {
                window.addEventListener('keydown', this.handleEsc);
            } else {
                window.removeEventListener('keydown', this.handleEsc);
            }
        },
    },
    components: {
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot
    }
};
</script>
