<template>
    <router-link :to="route" class="btn btn-sm btn-primary"
        ><div class="d-flex align-items-center">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="feather feather-plus-square align-middle me-2"
            >
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            {{ title }}
        </div></router-link
    >
</template>

<script>
export default {
    props: ["title", "route"],
};
</script>
