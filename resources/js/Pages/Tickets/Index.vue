<template>
    <AppLayout
        title="Tickets"
        btn-color="info"
        :action="true"
        :pages="pages"
        :search-enabled="true"
    >
        <div>
            <div class="w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <TicketsTable
                        :tickets="tickets"
                        @click-create="addTicket"
                        @search="search"
                    />
                </div>

                <JetDialogModal :show="isModelOpen" @close="closeForm">
                    <template #title> {{ modalTitle }}</template>

                    <template #content>
                        <TicketForm
                            v-model="form"
                            :is-editing="isEditing"
                        />
                    </template>

                    <template #footer>
                        <JetSecondaryButton @click="closeForm">
                            Cancel
                        </JetSecondaryButton>

                        <Button
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            class="ml-3"
                            @click="save"
                        >
                            Save
                        </Button>
                    </template>
                </JetDialogModal>

            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Button from "@/Components/Button";
import { computed, onMounted, ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import JetDialogModal from "@/Components/DialogModal.vue";
import JetSecondaryButton from "@/Components/SecondaryButton.vue";
import TicketsTable from "@/Components/Tickets/TicketsTable.vue";
import TicketForm from "@/Components/Tickets/TicketForm.vue";

const pages = [{ name: "Tickets", route: "tickets.index", current: true }];

let props = defineProps({
    tickets: {
        type: Object,
        required: true,
    },
    ticket: {
        type: Object,
        required: true,
    },
});


let form = useForm({
    id: null,
    name: "",
    problem: "",
    email: "",
    mobile: "",
    reply: "",
    referenceNumber: "",
});

let isModelOpen = ref(false);

let selectedTicket = ref({});

const isShowingDeleteConfirmationDialog = ref(false);

const isEditing = computed(() => !!props.ticket.data);

const modalTitle = computed(() => {
    if (isEditing.value) {
        return "Edit Ticket";
    }
    return "Add Ticket";
});

onMounted(() => {
    if (!props.ticket.data) {
        return;
    }
    form.id = props.ticket.data.id;
    form.name = props.ticket.data.name;
    form.problem = props.ticket.data.problem;
    form.email = props.ticket.data.email;
    form.mobile = props.ticket.data.mobile;
    form.reply = props.ticket.data.reply;
    form.referenceNumber = props.ticket.data.referenceNumber;

    isModelOpen.value = true;
});

function search(event) {
    Inertia.get(route("tickets.index"), {
        search: event
    });
}

function save() {
    if (isEditing.value) {
        return updateTicket();
    }
    saveTicket();
}

function saveTicket() {
    Inertia.post(route("tickets.store"), form, {
        onError: (errors) => {
            form.clearErrors().setError(errors);
        },
        onSuccess: () => {
            form.reset();
            isModelOpen.value = false;
        },
    });
}

function updateTicket() {
    Inertia.post(route("tickets.update", props.ticket.data.id), form, {
        onError: (errors) => {
            form.clearErrors().setError(errors);
        },
        onSuccess: () => {
            form.reset();
            isModelOpen.value = false;
        },
    });
}


function handleClickDelete(ticket) {
    selectedTicket.value = ticket;
    isShowingDeleteConfirmationDialog.value = true;
}


function closeForm() {
    Inertia.get(route("tickets.index"), {}, { replace: true });
    isModelOpen.value = false;
}

function addTicket(event) {
    isModelOpen.value = true;
}
</script>
