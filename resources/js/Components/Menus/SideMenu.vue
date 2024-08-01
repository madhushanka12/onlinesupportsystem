<template>
  <div class="app-menu">

    <a class="logo-box">
      <img :src="logo" class="logo-light h-12" alt="Light logo">
      <img :src="logo" class="logo-dark h-12" alt="Dark logo">
    </a>

    <div data-simplebar>
      <ul class="menu">
        <li class="menu-title">Menu</li>
        <SideBarItem
            v-for="item in singleMenus"
            v-show="item.access"
            :key="item.name"
            :item="item"
            :aria-current="item.current ? 'page' : undefined"
            class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 cursor-pointer"
            @click="handleMenuItemClick(item)"
        />
        <SideBarGroupItem
            v-for="item in nestedMenus"
            v-show="item.access"
            :key="item.name"
            :item="item"
            :has-active-child="
                            isActiveItem(item) || hasActiveChild(item)
                        "
            :active-condition="hasActiveChild(item)"
            class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 cursor-pointer"
        />

        <li class="menu-item px-3 py-2 rounded-sm mb-0.5 last:mb-0 cursor-pointer">
          <a href="/" target="_blank" class="menu-link">
            <LogoutIcon
                class="group-hover:text-gray-500 menu-icon h-6 w-6"
                aria-hidden="true"
            />
            <span class="menu-text !text-sm">Visit Website </span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import {Inertia} from "@inertiajs/inertia";
import {usePage} from "@inertiajs/inertia-vue3";
import {ChartBarIcon, FilmIcon, FlagIcon, GlobeAltIcon, HomeIcon, LogoutIcon, UsersIcon,} from "@heroicons/vue/solid";

import {onMounted, onUnmounted, ref, watch} from "vue";
import SideBarItem from "@/Components/SideBarItem.vue";
import SideBarGroupItem from "@/Components/SideBarGroupItem.vue";

const props = defineProps({
  sidebarOpen: {
    type: Boolean,
    default: false,
  },
});

defineEmits(["update:modelValue", "close-sidebar"]);
let page = usePage().props.value;
let logo = page.logo;
let menus = page.menus;

const trigger = ref(null);
const sidebar = ref(null);

const iconMap = {
  HomeIcon: HomeIcon,
  FlagIcon: FlagIcon,
  ChartBarIcon: ChartBarIcon,
  UsersIcon: UsersIcon,
  GlobeAltIcon: GlobeAltIcon,
  FilmIcon: FilmIcon,
};

function processMenu(menu) {
  const menuItem = {
    name: menu.name,
    access: menu.access,
    hasChildren: menu.hasChildren,
  };

  if (menu.params) {
    menuItem.params = menu.params;
  }

  if (menu.icon) {
    menuItem.icon = iconMap[menu.icon];
  }

  if (menu.route && !menu.hasChildren) {
    menuItem.route = menu.route;
    menuItem.callback = (component) => {
      inertiaVisit(menu.route, component, menuItem.params);
    };
  }

  if (menu.component) {
    menuItem.component = menu.component;
  }

  if (menu.children && menu.children.length > 0) {
    menuItem.children = menu.children.map((childMenu) =>
        processMenu(childMenu)
    );
  }

  return menuItem;
}

const navigation = menus.map((menu) => processMenu(menu));
const singleMenus = navigation.filter((menu) => !menu.hasChildren);
const nestedMenus = navigation.filter((menu) => menu.hasChildren);

function handleMenuItemClick(item) {
  if (typeof item.callback === "function") {
    item.callback(item.component);
  }
}

function inertiaVisit(path, component, params) {
  Inertia.visit(route(path, params));
  isActiveItem(component);
}

function hasActiveChild(item) {
  return item.children.some((child) => isActiveItem(child));
}

function isActiveItem(item) {
  const currentPageComponent = usePage().component.value;

  if (!item || !item.component || !currentPageComponent) {
    return false;
  }

  return currentPageComponent.split("/")[0] === item.component.split("/")[0];
}

const storedSidebarExpanded = localStorage.getItem("sidebar-expanded");
const sidebarExpanded = ref(
    storedSidebarExpanded === null ? false : storedSidebarExpanded === "true"
);

const clickHandler = ({target}) => {
  if (!sidebar.value || !trigger.value) return;
  if (
      !props.sidebarOpen ||
      sidebar.value.contains(target) ||
      trigger.value.contains(target)
  )
    return;
  emit("close-sidebar");
};

const keyHandler = ({keyCode}) => {
  if (!props.sidebarOpen || keyCode !== 27) return;
  emit("close-sidebar");
};

onMounted(() => {
  document.addEventListener("click", clickHandler);
  document.addEventListener("keydown", keyHandler);
});

onUnmounted(() => {
  document.removeEventListener("click", clickHandler);
  document.removeEventListener("keydown", keyHandler);
});

watch(sidebarExpanded, () => {
  localStorage.setItem("sidebar-expanded", sidebarExpanded.value);
  if (sidebarExpanded.value) {
    document.querySelector("body").classList.add("sidebar-expanded");
  } else {
    document.querySelector("body").classList.remove("sidebar-expanded");
  }
});

</script>
