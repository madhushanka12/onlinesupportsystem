<script setup>
import { defineEmits, ref, watch } from "vue";
import Checkbox from "@/Jetstream/Checkbox.vue";

const emit = defineEmits(["change-selection"]);

let props = defineProps({
    records: {
        type: Object,
        required: true,
    },
});

const selectAll = ref(false);
const selected = ref([]);

function checkAll() {
    selected.value = [];
    if (!selectAll.value) {
        selected.value = props.records.map((record) => record.id);
    }
}

watch(selected, () => {
    selectAll.value = props.records.length === selected.value.length;
    emit("change-selection", selected.value);
});
</script>

<template>
    <div class="flex items-center">
        <label class="inline-flex">
            <span class="sr-only">Select all</span>
            <Checkbox v-model="selectAll" @click="checkAll" />
        </label>
    </div>
</template>