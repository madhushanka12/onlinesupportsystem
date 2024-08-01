<template>
  <li class="menu-item">
    <a :class="[
            isActiveItem(item) ? 'bg-lime-200' : '','menu-link hover:bg-lime-300 focus:bg-lime-400 active:bg-lime-500']"
       :style="{ backgroundColor: isActiveItem(item) ? 'rgb(255 138 76)' : '' }">
      <component
          :is="item.icon"
          :class="[
                    isActiveItem(item)
                        ? 'text-white'
                        : 'group-hover:text-gray-500',
                    'menu-icon h-6 w-6',
                ]"
          aria-hidden="true"
      />
      <span :class="[
                isActiveItem(item)
                ?  'menu-text text-white'
                : '',
            ]"> {{ item.name }} </span>
    </a>
  </li>
</template>

<script setup>
import {usePage} from "@inertiajs/inertia-vue3";

let props = defineProps({
  item: {
    type: Object,
    default: true,
  },
});

function isActiveItem(item) {
  const currentPageComponent = usePage().component.value;

  if (!item || !item.component || !currentPageComponent) {
    return false;
  }

  return currentPageComponent.split("/")[0] === item.component.split("/")[0];
}
</script>

<style scoped>

</style>
