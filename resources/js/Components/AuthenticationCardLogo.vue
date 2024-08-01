<script setup>
import { Link } from '@inertiajs/vue3';
import {usePage} from "@inertiajs/inertia-vue3";

let page = usePage().props.value;
let logo = page.logo;
</script>

<template>
    <Link href="/admin/login">
        <img :src="logo">
    </Link>
</template>
