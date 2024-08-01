<template>
    <li class="menu-item">
        <a  :data-hs-collapse="`#sidenavErrorPages-${ item.id }`" class="menu-link">
             <component
                :is="item.icon"
                :class="[
                            isActiveItem(item)
                                ? 'text-white'
                                : 'text-white group-hover:text-gray-500',
                            'menu-icon cursor-pointer',
                        ]"
                aria-hidden="true"
            />
            <span class="menu-text">{{ item.name }}</span>
            <span class="menu-arrow"></span>
        </a>

        <ul :id="`sidenavErrorPages-${ item.id }`" class="sub-menu hidden">
            <li class="menu-item"
                v-for="child in item.children"
                v-show="child.access"
                :key="child.name"
                :aria-current="child.current ? 'page' : undefined"
                @click="handleMenuItemClick(child)"
            >
                <a class="menu-link">
                    <span class="menu-dot"></span>
                    <span class="menu-text">{{ child.name }}</span>
                </a>
            </li>
        </ul>
    </li>
</template>

<script setup>
import { computed, defineEmits, ref } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
const expandedNestedMenu = ref(null);

const props = defineProps({
    activeCondition: {
        type: Boolean,
        default: false,
    },
    hasActiveChild: {
        type: Boolean,
        default: false,
    },
    item: {
        type: Object,
        default: true,
    },
});

const emit = defineEmits(["toggle-expanded"]);

let expanded = ref(props.activeCondition);

function isActiveItem(item) {
    const currentPageComponent = usePage().component.value;
    if (!item || !item.component || !currentPageComponent) {
        return false;
    }

    return currentPageComponent.split("/")[0] === item.component.split("/")[0];
}

function handleNestedMenuClick(item) {
    if (typeof item.callback === "function") {
        item.callback(item.component);
    }
    expandedNestedMenu.value = isActiveItem(item);
}

function hasActiveChildComponent(item) {
    return isActiveItem(item);
}

function expandMenu() {
    expanded.value = !expanded.value;
}

const shouldExpand = computed(
    () => expanded.value || props.activeCondition || props.hasActiveChild
);

function handleMenuItemClick(item) {
    if (typeof item.callback === "function") {
        item.callback(item.component);
    }
}

</script>

<style scoped>

</style>
