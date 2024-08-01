<script setup>
import Checkbox from "@/Jetstream/Checkbox.vue";
import { computed } from "vue";

let props = defineProps({
    record: {
        type: Object,
        required: true,
    },
    value: {
        type: String,
        required: true,
    },
    selected: {
        type: Object,
        required: true,
    },
});

let emit = defineEmits(["update-selected"]);

function check(checked) {
    emit("update-selected", checked);
}

const checked = computed(() => props.selected.includes(props.value));
</script>

<template>
    <div class="flex items-center">
        <label class="inline-flex">
            <span class="sr-only">Select</span>
            <Checkbox
                :id="record.id"
                :value="value"
                :checked="checked"
                @update:checked="check"
            />
        </label>
    </div>
</template>