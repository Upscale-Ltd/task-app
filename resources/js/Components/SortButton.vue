<template>
    <button
        @click="onClick"
        :class="['px-4 py-2 rounded', isActive ? 'bg-blue-500 text-white' : 'bg-gray-200']"
    >
        {{ label }}
    </button>
</template>

<script>
export default {
    props: {
        label: {
            type: String,
            required: true,
        },
        value: {
            type: String,
            required: true,
        },
        activeSort: {
            type: String,
            required: true,
        },
    },
    computed: {
        isActive() {
            return this.value === this.activeSort;
        },
    },
    methods: {
        onClick() {
            this.$emit('update-sort', this.value);
        },
    },
};
</script>
