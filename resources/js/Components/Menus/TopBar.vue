<template>
    <header class="app-header flex items-center px-5 gap-4">
        <button id="button-toggle-menu" @click="toggleSidebar" class="nav-link p-2">
            <span class="sr-only">Menu Toggle Button</span>
            <span class="flex items-center justify-center h-6 w-6">
                        <i class="uil uil-bars text-2xl"></i>
                    </span>
        </button>

        <h4 class="text-slate-900 text-lg font-medium">{{ title }}</h4>

        <div class="flex justify-center items-center dark:bg-gray-500 ms-auto">
            <div class="bg-white dark:bg-gray-800 w-64 flex justify-center items-center">
                <div @click="open = !open" class="relative border-b-4 border-transparent py-3" :class="{'border-indigo-700 transform transition duration-300 ': open}">
                    <transition name="fade">
                        <div class="flex justify-center items-center space-x-3 cursor-pointer">
                            <div class="w-9 h-9 rounded-full overflow-hidden border-2 dark:border-white border-gray-900">
                                <img :src="user.profile_photo_url">
                            </div>
                            <div class="font-semibold dark:text-white text-gray-900 text-lg">
                                <div class="cursor-pointer">{{ user.name }}</div>
                            </div>
                        </div>
                    </transition>
                    <transition name="slide-fade">
                        <div v-show="open" class="absolute w-60 px-5 py-3 dark:bg-gray-800 bg-white rounded-lg shadow border dark:border-transparent mt-5">
                            <ul class="space-y-3 dark:text-white">
                                <li class="font-medium">
                                    <a
                                        href="#"
                                        class="flex items-center transform transition-colors duration-200 border-r-4 border-transparent hover:border-indigo-700"
                                        @click="logout"
                                    >
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </transition>
                </div>
            </div>
        </div>
    </header>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import {usePage} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";

defineProps({
    title: {
        type: String,
        default: "Dashboard",
    },
})

const sidebarOpen = ref(false);
const open = ref(false);
const profileBarOpen = ref(false);
let page = usePage().props.value;
let logo = page.logo;
let user = page.user;

const htmlElement = ref(null);

const toggleSidebar = () => {
    const view = htmlElement.value.getAttribute('data-sidebar-view');

    if (view === 'mobile') {
        sidebarOpen.value = !sidebarOpen.value;
        htmlElement.value.classList.toggle('sidebar-open', sidebarOpen.value);
    } else {
        if (view === 'hidden') {
            htmlElement.value.setAttribute('data-sidebar-view', 'default');
        } else {
            htmlElement.value.setAttribute('data-sidebar-view', 'hidden');
        }
    }
};

const toggleProfileBar = () => {
    const view = htmlElement.value.getAttribute('data-profile-view');

    if (view === 'hidden') {
        htmlElement.value.setAttribute('data-profile-view', 'default');
    } else {
        htmlElement.value.setAttribute('data-profile-view', 'hidden');
    }
};

function logout() {
    Inertia.post(route("admin.logout"));
}

onMounted(() => {
    htmlElement.value = document.documentElement;
});
</script>
