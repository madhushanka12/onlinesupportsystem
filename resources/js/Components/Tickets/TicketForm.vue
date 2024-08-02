<template>
    <form ref="connectionForm">
        <div class="mt-5 md:mt-0 md:col-span-2">
            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6">
                        <Label>Name</Label>
                        <Input
                            id="name"
                            v-model="form.name"
                            autocomplete="name"
                            class="mt-1 block w-full"
                            name="name"
                            type="text"
                        />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <Label>E-Mail</Label>
                        <Input
                            id="email"
                            v-model="form.email"
                            autocomplete="email"
                            class="mt-1 block w-full"
                            name="email"
                            type="text"
                        />
                        <InputError :message="form.errors.email" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <Label>Mobile</Label>
                        <Input
                            id="mobile"
                            v-model="form.mobile"
                            autocomplete="mobile"
                            class="mt-1 block w-full"
                            name="mobile"
                            type="text"
                        />
                        <InputError :message="form.errors.mobile" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <Label>Reference Number</Label>
                        <Input
                            id="referenceNumber"
                            v-model="form.referenceNumber"
                            autocomplete="referenceNumber"
                            class="mt-1 block w-full"
                            name="referenceNumber"
                            type="text"
                        />
                        <InputError :message="form.errors.referenceNumber" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <Label>Problem</Label>
                        <Input
                            id="problem"
                            v-model="form.problem"
                            autocomplete="problem"
                            class="mt-1 block w-full"
                            name="problem"
                            type="text"
                        />
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

<style src="@vueform/multiselect/themes/default.css"></style>
