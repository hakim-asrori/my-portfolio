<template>
    <h1 class="h3 mb-3">Projects</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ButtonAdd
                        :route="'/project/create'"
                        :title="'Add New Project'"
                    />
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
                        :feature="'project'"
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

    <DeleteModal id="deleteModal" @onDelete="deleteProject" />

    <SuccessModal :msg="message" />
</template>

<script>
import ButtonAdd from "../../components/ButtonAdd.vue";
import Loader from "../../components/Loader.vue";
import DeleteModal from "../../components/modals/DeleteModal.vue";
import SuccessModal from "../../components/modals/SuccessModal.vue";
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
            deleteId: null,

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
                    this.isLoading = false;

                    this.projects = response.data.map((project) => {
                        if (project.projectStatus == 1) {
                            project.projectStatus = "Active";
                        } else {
                            project.projectStatus = "Inactive";
                        }

                        return project;
                    });

                    this.metaPagination = response.meta;
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
        deleteProject() {
            $("#deleteModal").modal("hide");
            this.isLoading = true;

            this.$store
                .dispatch("deleteData", ["project/trash", this.deleteId])
                .then((result) => {
                    this.isLoading = false;
                    this.message = "data has been deleted";

                    this.getProject();

                    $("#successModal").modal("show");
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
        onDelete(e) {
            this.deleteId = e;
            $("#deleteModal").modal("show");
        },
        onPageChange(e) {
            this.pagination.page = e;
            this.getProject();
        },
    },
    components: {
        Loader,
        Pagination,
        Table,
        DeleteModal,
        SuccessModal,
        ButtonAdd,
    },
};
</script>
