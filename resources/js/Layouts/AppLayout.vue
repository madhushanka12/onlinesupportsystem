<script setup>
import SideMenu from "@/Components/Menus/SideMenu.vue";
import TopBar from "@/Components/Menus/TopBar.vue";
import Footer from "@/Components/Menus/Footer.vue";
import Notification from "@/Components/Notification.vue";
import { Head } from "@inertiajs/inertia-vue3";

defineProps({
    title: {
        type: String,
        default: "Dashboard",
    },
})

</script>

<template>
    <div class="app-wrapper">

      <Head :title="title" />

        <SideMenu />

        <div class="app-content">

            <TopBar
                :title="title"
            />

            <main class="p-6">
                <slot />
            </main>
            <Footer />
        </div>

        <div id="search-modal"
             class="hs-overlay hidden w-full h-full fixed top-0 start-0 z-[60] overflow-x-hidden overflow-y-auto pointer-events-none">
            <div
                class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
                <div
                    class="flex flex-col bg-white shadow-sm rounded-xl pointer-events-auto overflow-hidden">
                    <div class="relative z-[60]">
                        <input type="search" id="search-input" class="form-input ps-10">
                        <span class="absolute start-3 top-1.5">
                            <i class="uil uil-search text-lg"></i>
                        </span>

                        <span class="absolute end-3 top-1.5">
                            <button data-hs-overlay="#search-modal">
                                <i class="uil uil-times text-lg"></i>
                            </button>
                        </span>
                    </div>

                </div>
            </div>
        </div>

        <Notification />
    </div>
</template>
