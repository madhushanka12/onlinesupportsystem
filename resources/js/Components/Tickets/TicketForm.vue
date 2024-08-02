<template>
    <form ref="connectionForm">
        <div class="mt-5 md:mt-0 md:col-span-2">
            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6">
                        <Label>Name</Label>
                        <div class="read-only-field">{{ form.name }}</div>
                    </div>
                    <div class="col-span-6">
                        <Label>E-Mail</Label>
                        <div class="read-only-field">{{ form.email }}</div>
                    </div>
                    <div class="col-span-6">
                        <Label>Mobile</Label>
                        <div class="read-only-field">{{ form.mobile }}</div>
                    </div>
                    <div class="col-span-6">
                        <Label>Reference Number</Label>
                        <div class="read-only-field">{{ form.referenceNumber }}</div>
                    </div>
                    <div class="col-span-6">
                        <Label>Problem</Label>
                        <div class="read-only-field">{{ form.problem }}</div>
                        <InputError :message="form.errors.problem" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <Label>Reply</Label>
                        <textarea
                            id="reply"
                            v-model="form.reply"
                            autocomplete="reply"
                            class="mt-1 block w-full"
                            name="reply"
                            type="text"
                        />
                        <InputError :message="form.errors.reply" class="mt-2" />
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script setup>
import Input from "@/Components/Input";
import Label from "@/Components/Label.vue";
import InputError from "@/Components/InputError.vue";
import { ref, watch } from "vue";
import Textarea from "@/Components/Textarea.vue";

let props = defineProps({
    modelValue: {
        type: Object,
        required: true,
    },
    isEditing: {
        type: Boolean,
        required: true,
    },
});

const form = ref(props.modelValue);


watch(
    form,
    () => {
        emit("update:modelValue", form.value);
    },
    { deep: true }
);

const emit = defineEmits(["update:modelValue", "save"]);
</script>
<style scoped>
.read-only-field {
    display: block;
    width: 100%;
    padding: 0.5rem 0.75rem;
    font-size: 1rem;
    line-height: 1.25;
    color: #6b7280;
    background-color: #f9fafb;
}
</style>
<style src="@vueform/multiselect/themes/default.css"></style>
