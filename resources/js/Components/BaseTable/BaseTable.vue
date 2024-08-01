<template>
  <div class="card bg-white relative overflow-x-auto">
    <div class="card-header flex justify-between items-center">
      <h4 class="card-title">{{ title }}</h4>

      <div class="flex items-center">
        <div class="relative mx-auto text-gray-600">
          <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-12 rounded-lg text-sm focus:outline-none"
                 type="search" name="search" autocomplete="off" placeholder="Search Anything"
                 v-model="searchTerm"
                 @input="handleSearch">
          <button type="button" class="absolute right-0 top-0 mt-2 mr-4">
            <SearchIcon class="text-gray-600 h-6 w-6 fill-current"/>
          </button>
        </div>

        <div v-if="hasButton" class="ml-4">
          <Link
              v-if="buttonRoute && isButton && showButton"
              :href="buttonRoute" class="btn btn-sm bg-orange-400 !text-sm text-white">{{ buttonText }}
          </Link>
          <button
              v-else-if="!buttonRoute && isButton && showButton"
              @click="$emit('button-clicked')" class="btn btn-sm bg-orange-400 !text-sm text-white">{{ buttonText }}
          </button>
        </div>
      </div>

    </div>
    <div class="min-w-full inline-block align-middle whitespace-nowrap">
      <div class=" relative overflow-x-auto">
        <table class="min-w-full">
          <slot></slot>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import {Link} from "@inertiajs/inertia-vue3";
import {SearchIcon} from "@heroicons/vue/solid";
import {ref} from "vue";

const emit = defineEmits(["search"]);

let props = defineProps({
  title: {
    type: String,
    default: 'Table',
  },
  hasButton: {
    type: Boolean,
    default: true
  },
  buttonText: {
    type: String,
    default: 'Create'
  },
  buttonRoute: {
    type: String,
    default: null
  },
  isButton: {
    type: Boolean,
    default: true
  },
  showButton: {
    type: Boolean,
    default: true
  }
});

let urlSearchParams = new URLSearchParams(window.location.search);
let searchTerm = ref(urlSearchParams.get('search') || '');
removeSearchParam()

const handleSearch = () => {
  emit('search', searchTerm.value);
  removeSearchParam()
}

function removeSearchParam() {
  if (searchTerm.value.trim() === '') {
    urlSearchParams.delete('search');
    window.history.replaceState({}, '', window.location.pathname + '?' + urlSearchParams.toString());
  }
}
</script>
