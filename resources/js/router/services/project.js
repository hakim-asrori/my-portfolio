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
        path: "/project/:id/edit",
        name: "Edit Project",
        component: () => import("../../pages/project/Edit.vue"),
        meta: {
            middleware: "auth",
        },
        props: true,
    },
];
