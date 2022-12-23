<template>
    <div class="d-flex align-items-center mb-3">
        <router-link :to="'/' + route" class="text-dark">
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
                class="feather feather-arrow-left-circle"
            >
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 8 8 12 12 16"></polyline>
                <line x1="16" y1="12" x2="8" y2="12"></line>
            </svg>
        </router-link>
        <span style="font-size: 1.3125rem" class="ms-3" v-html="title"></span>
    </div>
</template>

<script>
export default {
    props: ["title", "route"],
};
</script>
