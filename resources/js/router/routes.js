const routes = [
    {
        path: "/",
        name: "Login",
        component: () => import("../pages/auth/Login.vue"),
        meta: {
            middleware: "guest",
        },
    },
];

export default routes;
