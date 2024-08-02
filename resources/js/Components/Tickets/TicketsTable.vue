<template>
    <BaseTable
        :title="`Ticket`"
        :button-text="`Create`"
        @button-clicked="onClickCreate"
        :has-button="false"
        @search="emit('search', $event)"
    >
        <BaseTableThead>
            <BaseTableTr>
                <BaseTableTh>Name</BaseTableTh>
                <BaseTableTh>Reference Number</BaseTableTh>
                <BaseTableTh>Problem</BaseTableTh>
                <BaseTableTh> email</BaseTableTh>
                <BaseTableTh> mobile</BaseTableTh>
                <BaseTableTh> status</BaseTableTh>
                <BaseTableTh> Action</BaseTableTh>
            </BaseTableTr>
        </BaseTableThead>

        <BaseTableTbody>
            <TicketsTableRow
                v-for="ticket in tickets.data"
                :key="ticket.id"
                :ticket="ticket"
                @click-permissions="emit('click-permissions', $event)"
            />
        </BaseTableTbody>
        <BaseTableFooter v-if="!tickets.data.length" :data-length="5" />
    </BaseTable>

    <Pagination :items="tickets" />
</template>
<script setup>
import { defineEmits } from "vue";
import Pagination from "@/Components/Pagination.vue";
import BaseTableThead from "@/Components/BaseTable/BaseTableThead.vue";
import BaseTableTbody from "@/Components/BaseTable/BaseTableTbody.vue";
import BaseTableTr from "@/Components/BaseTable/BaseTableTr.vue";
import BaseTableTh from "@/Components/BaseTable/BaseTableTh.vue";
import BaseTableFooter from "@/Components/BaseTable/BaseTableFooter.vue";
import BaseTable from "@/Components/BaseTable/BaseTable.vue";
import TicketsTableRow from "@/Components/Tickets/TicketsTableRow.vue";

let props = defineProps({
    tickets: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(["click-create", "search"]);

const onClickCreate = ($event) => {
    emit('click-create', $event);
};
</script>

<style scoped></style>
