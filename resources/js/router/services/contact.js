export default [
    {
        path: "/admin/contact",
        name: "Contact",
        component: () => import("../../pages/contact/Index.vue"),
        meta: {
            middleware: "auth",
        },
    },
];
