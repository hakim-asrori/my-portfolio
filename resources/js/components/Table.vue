<template>
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <th v-if="numeric">No</th>
                    <th v-for="(heading, index) in headings" :key="index">
                        {{ heading }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(item, index) in data"
                    :key="index"
                    v-if="data.length > 0"
                >
                    <td v-if="numeric">{{ iteration(index) }}</td>
                    <td
                        v-for="variable in variables"
                        v-html="item[variable]"
                    ></td>
                    <td>
                        <router-link
                            v-if="isDetail"
                            :to="`/${feature}/${item['id']}/detail`"
                            class="btn btn-sm me-2 btn-info text-white"
                            ><svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="feather feather-eye align-middle"
                            >
                                <path
                                    d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"
                                ></path>
                                <circle cx="12" cy="12" r="3"></circle></svg
                        ></router-link>
                        <router-link
                            v-if="isEdit"
                            :to="`/${feature}/${item['id']}/edit`"
                            class="btn btn-sm me-2 btn-warning text-white"
                            ><svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="feather feather-edit align-middle"
                            >
                                <path
                                    d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"
                                ></path>
                                <path
                                    d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"
                                ></path></svg
                        ></router-link>
                        <button
                            v-if="isDelete"
                            class="btn btn-sm me-2 btn-danger text-white"
                            @click="handleDelete(item.id)"
                        >
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
                                class="feather feather-trash-2 align-middle"
                            >
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path
                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"
                                ></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </button>
                    </td>
                </tr>
                <tr v-else>
                    <td colspan="100%" class="text-center">
                        No matching records found
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        feature: {
            type: String,
            default: "",
        },
        isDetail: {
            type: Boolean,
            default: true,
        },
        isEdit: {
            type: Boolean,
            default: true,
        },
        isDelete: {
            type: Boolean,
            default: true,
        },
        numeric: {
            type: Boolean,
            default: true,
        },
        headings: {
            type: Array,
            default: [],
        },
        data: {
            type: Object,
            default: {},
        },
        variables: {
            type: Array,
            default: [],
        },
    },
    data() {
        return {};
    },
    methods: {
        iteration(index) {
            return (
                (this.metaPagination.currentPage - 1) *
                    this.metaPagination.perPage +
                index +
                1
            );
        },
        handleDelete(id) {
            this.$emit("onDelete", id);
        },
    },
};
</script>

<!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail align-middle"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg> -->
