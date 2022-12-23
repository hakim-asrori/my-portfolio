import "./bootstrap";
import { createApp } from "vue";
import router from "./router";
import store from "./store";
import CKEditor from "@ckeditor/ckeditor5-vue";

import "../css/app.css";

import Auth from "./Auth.vue";
import App from "./App.vue";

createApp(Auth).use(router).use(store).mount("#auth");
createApp(App).use(router).use(store).use(CKEditor).mount("#app");
