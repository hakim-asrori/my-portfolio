import contact from "./services/contact";
import project from "./services/project";

const routes = [
    ...contact,
    ...project,
    {
        path: "/auth/login",
        name: "Login",
        component: () => import("../pages/auth/Login.vue"),
        meta: {
            middleware: "guest",
        },
    },
    {
        path: "/",
        name: "Home",
        component: () => import("../pages/home/Index.vue"),
        meta: {
            middleware: "auth",
        },
    },
];

export default routes;
