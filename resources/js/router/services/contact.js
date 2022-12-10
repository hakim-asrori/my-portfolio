export default [
    {
        path: "/contact",
        name: "Contact",
        component: () => import("../../pages/contact/Index.vue"),
        meta: {
            middleware: "auth",
        },
    },
    {
        path: "/contact/:id/detail",
        name: "Detail Contact",
        component: () => import("../../pages/contact/Detail.vue"),
        meta: {
            middleware: "auth",
        },
        props: true,
    },
];
