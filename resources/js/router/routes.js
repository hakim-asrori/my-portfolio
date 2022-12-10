import contact from "./services/contact";

const routes = [
    ...contact,
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
