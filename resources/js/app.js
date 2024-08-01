import "./bootstrap.js";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import { QuillEditor } from "@vueup/vue-quill";

const globalOptions = {
    debug: "info",
    placeholder: "Compose an epic...",
    theme: "snow",
};

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText ||
    "PVCU";
QuillEditor.props.globalOptions.default = () => globalOptions;

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    // resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: "#4B5563" });
