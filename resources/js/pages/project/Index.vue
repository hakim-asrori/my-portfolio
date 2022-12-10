<template>
    <h1 class="h3 mb-3">Project</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"></h5>
                </div>
                <Loader v-if="isLoading" />
                <div class="card-body">
                    <div
                        class="d-flex justify-content-between flex-md-row flex-xs-column align-items-center"
                    >
                        <input
                            type="search"
                            class="form-control"
                            style="width: 30%; margin-top: -10px"
                            @keyup="onSearch"
                            v-model="search"
                        />

                        <Pagination
                            :pagination="metaPagination"
                            @onPageChange="onPageChange($event)"
                        />
                    </div>

                    <Table
                        :feature="'contact'"
                        :isShow="true"
                        :isPaginate="true"
                        :isSort="false"
                        :isSearch="true"
                        :isEdit="false"
                        :numeric="false"
                        :headings="headings"
                        :data="projects"
                        :variables="variables"
                        @onSort="onSort($event)"
                        @onSearch="onSearch($event)"
                        @onDelete="onDelete($event)"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Loader from "../../components/Loader.vue";
import Pagination from "../../components/Pagination.vue";
import Table from "../../components/Table.vue";

export default {
    data() {
        return {
            isLoading: false,

            headings: [
                "Project Name",
                "Project Domain",
                "Project Status",
                "Action",
            ],
            variables: ["projectName", "projectDomain", "projectStatus"],

            projects: [],

            search: "",
            pagination: {
                perPage: 10,
                page: 1,
            },
            metaPagination: {},
        };
    },
    mounted() {
        this.getProject();
    },
    methods: {
        getProject() {
            this.isLoading = true;
            const params = [
                `per_page=${this.pagination.perPage}`,
                `page=${this.pagination.page}`,
                `search=${this.search}`,
            ].join("&");

            this.$store
                .dispatch("getData", ["project", params])
                .then((response) => {
                    console.log(response);
                    this.isLoading = false;
                    this.projects = response.data;
                    this.metaPagination = response.meta;
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
    },
    components: { Loader, Pagination, Table },
};
</script>
