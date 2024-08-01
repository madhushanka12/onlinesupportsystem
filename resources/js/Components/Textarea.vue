<template>
    <textarea
        ref="input"
        :value="modelValue"
        class="appearance-none block w-full bg-white text-gray-500 py-3 px-4 leading-tight border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        cols="50"
        rows="8"
        @input="$emit('update:modelValue', $event.target.value)"
    >
        <slot/>
    </textarea>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
    props: {
        modelValue: {
            type: [String, Number, Object],
            default: null,
        },
    },

    emits: ["update:modelValue"],
});
</script>
