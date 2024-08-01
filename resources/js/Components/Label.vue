<script>
import { defineComponent } from "vue";

export default defineComponent({
    props: {
        value: {
            type: String,
            default: null,
        },
        required: {
            type: Boolean,
            default: false,
        },
        note: {
            type: String,
            default: null,
        },
    },
});
</script>

<template>
    <label class="text-gray-800 text-sm font-medium inline-block mb-2">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
        <span v-if="required" class="text-red-600 font-bold"> * </span>
        <small v-if="note">
            <span class="text-red-600">Please note: </span>
            <span class="text-blue-500 font-xs">{{ note }}</span>
        </small>
    </label>
</template>
