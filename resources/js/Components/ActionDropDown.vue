<template>
    <Menu as="div" class="inline-block text-left">
        <div>
            <MenuButton
                class="inline-flex w-full justify-center text-sm font-medium text-gray hover:bg-opacity-30 focus:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-opacity-75"
            >
                <svg
                    class="h-6 w-6"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </MenuButton>
        </div>

      <transition
          enter-active-class="transition duration-100 ease-out"
          enter-from-class="transform scale-95 opacity-0"
          enter-to-class="transform scale-100 opacity-100"
          leave-active-class="transition duration-75 ease-in"
          leave-from-class="transform scale-100 opacity-100"
          leave-to-class="transform scale-95 opacity-0"
      >
        <div class="relative z-50">
          <MenuItems
              class="absolute md:right-8 lg:right-7 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
          >
            <div class="px-1 py-1">
              <MenuItem
                  v-for="(action, index) in actions"
                  v-show="action.active"
                  :key="index"
                  v-slot="{ active }"
              >
                <button
                    :class="[
                            active ? 'bg-orange-400 text-white ' : 'text-gray-900',
                            'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                        ]"
                    @click="action.callback()"
                >
                  <component
                      :is="action.icon"
                      :class="[
                                active ? 'text-white' : 'text-gray-400',
                                'h-5 w-5 mr-1',
                            ]"
                      aria-hidden="true"
                  />
                  {{ action.name }}
                </button>
              </MenuItem>
            </div>
          </MenuItems>
        </div>
      </transition>

    </Menu>
</template>

<script setup>
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";

let props = defineProps({
    actions: {
        type: Array,
        required: true,
    },
});
</script>
