<script setup>
import {defineEmits, defineProps} from 'vue';

const props = defineProps({
  disabled: {
    type: Boolean,
    default: false
  },
  btnColor: {
    type: String,
    default: 'blue'
  },
  type: {
    type: String,
    default: 'button'
  }
});

const handleClick = () => {
  defineEmits(["click"]);
};

</script>

<template>
  <div class="flex-none">
    <button
        :disabled="disabled"
        :type="type"
        :class="`bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 ${disabled ? 'opacity-50 cursor-not-allowed' : ''}`"
        @click="handleClick">
      <slot/>
    </button>
  </div>
</template>

<style scoped>
</style>
