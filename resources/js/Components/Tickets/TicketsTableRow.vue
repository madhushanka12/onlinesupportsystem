<template>
    <BaseTableTr>
        <BaseTableTd> {{ ticket.name }}</BaseTableTd>
        <BaseTableTd> {{ ticket.referenceNumber }}</BaseTableTd>
        <BaseTableTd> {{ ticket.problem }}</BaseTableTd>
        <BaseTableTd> {{ ticket.email }}</BaseTableTd>
        <BaseTableTd> {{ ticket.mobile }}</BaseTableTd>
        <BaseTableTd> {{ ticket.status }}</BaseTableTd>
        <BaseTableTd>
            <ActionDropDown :actions="actions" class="px-4" />
        </BaseTableTd>
    </BaseTableTr>
</template>

<script setup>
import { defineEmits } from "vue";
import BaseTableTr from "@/Components/BaseTable/BaseTableTr";
import BaseTableTd from "@/Components/BaseTable/BaseTableTd";
import ActionDropDown from "@/Components/ActionDropDown";
import { Inertia } from "@inertiajs/inertia";
import { PencilIcon, TrashIcon } from "@heroicons/vue/solid";

let props = defineProps({
    ticket: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(["select-row"]);

const actions = [
    {
        active: true,
        name: "Edit",
        callback: () => {
            Inertia.visit(route("categories.show", { id: props.ticket.id }));
        },
        icon: PencilIcon,
    },
];

</script>

<style scoped></style>
