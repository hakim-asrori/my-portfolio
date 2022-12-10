export default [
    {
        path: "/project",
        name: "Project",
        component: () => import("../../pages/project/Index.vue"),
        meta: {
            middleware: "auth",
        },
    },
    {
        path: "/project/:id/detail",
        name: "Detail Project",
        component: () => import("../../pages/project/Detail.vue"),
        meta: {
            middleware: "auth",
        },
        props: true,
    },
    {
        path: "/project/:id/edit",
        name: "Edit Project",
        component: () => import("../../pages/project/Edit.vue"),
        meta: {
            middleware: "auth",
        },
        props: true,
    },
];
