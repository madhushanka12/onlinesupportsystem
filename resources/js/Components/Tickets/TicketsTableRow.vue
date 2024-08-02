<template>
    <BaseTableTr :class="{'highlight-pending': ticket.status === 'pending'}">
        <BaseTableTd> {{ ticket.name }}</BaseTableTd>
        <BaseTableTd> {{ ticket.referenceNumber }}</BaseTableTd>
        <BaseTableTd> {{ ticket.email }}</BaseTableTd>
        <BaseTableTd> {{ ticket.mobile }}</BaseTableTd>
        <BaseTableTd> {{ ticket.status }}</BaseTableTd>
        <BaseTableTd>
            <span
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize text-green-800 bg-green-100 cursor-pointer"
                @click="viewDetails()"
            >View & Reply
            </span>
        </BaseTableTd>
    </BaseTableTr>
</template>

<script setup>
import { defineEmits } from "vue";
import BaseTableTr from "@/Components/BaseTable/BaseTableTr";
import BaseTableTd from "@/Components/BaseTable/BaseTableTd";
import { Inertia } from "@inertiajs/inertia";

let props = defineProps({
    ticket: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(["select-row"]);




function viewDetails() {
    Inertia.visit(route("tickets.show", { id: props.ticket.id }));
}

</script>

<style scoped>
.highlight-pending {
    background-color: #ffe4e1; 
}
</style>
