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
        path: "/project/create",
        name: "Create Project",
        component: () => import("../../pages/project/Create.vue"),
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
];
