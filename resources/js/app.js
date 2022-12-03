import "./bootstrap";
import { createApp } from "vue";
import router from "./router";
import store from "./store";

import "../css/app.css";

import Auth from "./Auth.vue";

createApp(Auth).use(router).use(store).mount("#auth");
