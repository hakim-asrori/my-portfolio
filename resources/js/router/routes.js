import contact from "./services/contact";

const routes = [
    ...contact,
    {
        path: "/",
        name: "Login",
        component: () => import("../pages/auth/Login.vue"),
        meta: {
            middleware: "guest",
        },
    },
    {
        path: "/admin",
        name: "Home2",
        component: () => import("../pages/home/Index.vue"),
        meta: {
            middleware: "auth",
        },
    },
    {
        path: "/admin/home",
        name: "Home",
        component: () => import("../pages/home/Index.vue"),
        meta: {
            middleware: "auth",
        },
    },
];

export default routes;
