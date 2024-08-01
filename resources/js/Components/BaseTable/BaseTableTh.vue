<template>
    <th
        class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px"
        scope="col"
    >
        <div class="font-semibold text-left">
            <slot></slot>
        </div>
    </th>
</template>

<script>
export default {
    name: "BaseTableTh",
};
</script>
