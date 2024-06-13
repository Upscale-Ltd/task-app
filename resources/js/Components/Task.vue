<script>
export default {
    props: {
        task: Object,
    },
};
</script>

<template>
    <li class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6">
        <div class="flex min-w-0 gap-x-4">
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input id="task" name="task" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="task" class="font-medium text-gray-900">
                        {{ task.label }}
                    </label>
                </div>
            </div>
        </div>
        <div class="flex shrink-0 items-center gap-x-4">
            <div class="hidden sm:flex sm:items-center text-gray-400/75">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 mr-2">
                    <path fill-rule="evenodd" d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2Zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75Z" clip-rule="evenodd" />
                </svg>

                <p class="text-sm leading-6 text-gray-900">
                    {{ task.deadline }}
                </p>
            </div>
        </div>
    </li>
</template>
