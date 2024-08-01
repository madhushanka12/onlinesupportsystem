d<template>
    <div
        class="relative bg-indigo-200 p-4 sm:p-6 rounded-sm overflow-hidden mb-8"
    >
        <div
            aria-hidden="true"
            class="absolute right-0 top-0 -mt-4 mr-16 pointer-events-none hidden xl:block"
        >
            <svg
                height="198"
                width="319"
                xmlns:xlink="http://www.w3.org/1999/xlink"
            >
                <defs>
                    <path id="welcome-a" d="M64 0l64 128-64-20-64 20z" />
                    <path id="welcome-e" d="M40 0l40 80-40-12.5L0 80z" />
                    <path id="welcome-g" d="M40 0l40 80-40-12.5L0 80z" />
                    <linearGradient
                        id="welcome-b"
                        x1="50%"
                        x2="50%"
                        y1="0%"
                        y2="100%"
                    >
                        <stop offset="0%" stop-color="#A5B4FC" />
                        <stop offset="100%" stop-color="#818CF8" />
                    </linearGradient>
                    <linearGradient
                        id="welcome-c"
                        x1="50%"
                        x2="50%"
                        y1="24.537%"
                        y2="100%"
                    >
                        <stop offset="0%" stop-color="#4338CA" />
                        <stop
                            offset="100%"
                            stop-color="#6366F1"
                            stop-opacity="0"
                        />
                    </linearGradient>
                </defs>
                <g fill="none" fill-rule="evenodd">
                    <g transform="rotate(64 36.592 105.604)">
                        <mask id="welcome-d" fill="#fff">
                            <use xlink:href="#welcome-a" />
                        </mask>
                        <use fill="url(#welcome-b)" xlink:href="#welcome-a" />
                        <path
                            d="M64-24h80v152H64z"
                            fill="url(#welcome-c)"
                            mask="url(#welcome-d)"
                        />
                    </g>
                    <g transform="rotate(-51 91.324 -105.372)">
                        <mask id="welcome-f" fill="#fff">
                            <use xlink:href="#welcome-e" />
                        </mask>
                        <use fill="url(#welcome-b)" xlink:href="#welcome-e" />
                        <path
                            d="M40.333-15.147h50v95h-50z"
                            fill="url(#welcome-c)"
                            mask="url(#welcome-f)"
                        />
                    </g>
                    <g transform="rotate(44 61.546 392.623)">
                        <mask id="welcome-h" fill="#fff">
                            <use xlink:href="#welcome-g" />
                        </mask>
                        <use fill="url(#welcome-b)" xlink:href="#welcome-g" />
                        <path
                            d="M40.333-15.147h50v95h-50z"
                            fill="url(#welcome-c)"
                            mask="url(#welcome-h)"
                        />
                    </g>
                </g>
            </svg>
        </div>

        <div class="relative">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold mb-1">
                {{ greeting() }}, {{ user.name }} 👋
            </h1>
            <p>Here is what’s happening with your website today:</p>
        </div>
    </div>
</template>

<script setup>
import { usePage } from "@inertiajs/inertia-vue3";

let page = usePage().props.value;
let user = page.user;
let role = page.role;
function greeting() {
    const date = new Date();
    const hrs = date.getHours();

    let greet;

    if (hrs < 12) greet = "Good Morning";
    else if (hrs >= 12 && hrs <= 17) greet = "Good Afternoon";
    else if (hrs >= 17 && hrs <= 24) greet = "Good Evening";
    return greet;
}
</script>
