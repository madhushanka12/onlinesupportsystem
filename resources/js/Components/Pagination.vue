<template>
    <div
        class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 text-xs font-semibold text-slate-500 bg-slate-50 border-t border-b border-slate-200"
    >
        <div class="flex-1 flex justify-between sm:hidden"></div>
        <div
            class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"
        >
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    {{ " " }}
                    <span class="font-medium">{{ items.from }}</span>
                    {{ " " }}
                    to
                    {{ " " }}
                    <span class="font-medium">{{ items.to }}</span>
                    {{ " " }}
                    of
                    {{ " " }}
                    <span class="font-medium">{{ items.total }}</span>
                    {{ " " }}
                    results
                </p>
            </div>
            <div>
                <nav
                    aria-label="Pagination"
                    class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                >
                    <Link
                        :href="items.prev_page_url"
                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                    >
                        <span class="sr-only">Previous</span>
                        <ChevronLeftIcon aria-hidden="true" class="h-5 w-5" />
                    </Link>
                    <template
                        v-for="(link, key) in pageLinks"
                        :key="`link-${key}`"
                    >
                        <Link
                            :class="{
                                'z-10 bg-orange-400 border-orange-500 text-white hover:bg-orange-500':
                                    link.active,
                            }"
                            :href="link.url"
                            class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                            v-html="link.label"
                        />
                    </template>
                    <Link
                        :href="items.next_page_url"
                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                    >
                        <span class="sr-only">Next</span>
                        <ChevronRightIcon aria-hidden="true" class="h-5 w-5" />
                    </Link>
                </nav>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/vue/solid";
import { Link } from "@inertiajs/inertia-vue3";
import { computed, defineProps } from "vue";

let props = defineProps({
    items: {
        type: Object,
        required: true,
    },
});

let pageLinks = computed(() => {
    if (!props.items.links) {
        return;
    }

    return props.items.links.filter((link) => {
        return !(
            link.label === "&laquo; Previous" || link.label === "Next &raquo;"
        );
    });
});
</script>

<style scoped></style>
