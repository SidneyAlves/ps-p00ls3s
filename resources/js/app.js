require("./bootstrap");

window.Vue = require("vue").default;

import vuetify from "./vuetify";
import VueRouter from "vue-router";

Vue.use(VueRouter);
const routes = [
    {
        path: "/",
        name: "Index",
        component: require("./views/index.vue").default
    },
    {
        path: "/dimensions",
        name: "Dimensions",
        component: require("./views/dimensions.vue").default
    }
];

const router = new VueRouter({
    routes: routes,
    mode: "history"
});

const app = new Vue({
    router,
    vuetify,
    el: "#app"
});
