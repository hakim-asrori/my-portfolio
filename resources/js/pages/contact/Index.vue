<template>
    <h1 class="h3 mb-3">Contacts</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <!-- <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a
                                class="nav-link active"
                                aria-current="page"
                                href="#"
                                >Active</a
                            >
                        </li>
                        <li class="nav-item dropdown">
                            <a
                                class="nav-link dropdown-toggle"
                                data-bs-toggle="dropdown"
                                href="#"
                                role="button"
                                aria-expanded="false"
                                >Dropdown</a
                            >
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#">Action</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#"
                                        >Another action</a
                                    >
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#"
                                        >Something else here</a
                                    >
                                </li>
                                <li><hr class="dropdown-divider" /></li>
                                <li>
                                    <a class="dropdown-item" href="#"
                                        >Separated link</a
                                    >
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled">Disabled</a>
                        </li>
                    </ul> -->
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
                        :data="tickets"
                        :variables="variables"
                        @onSort="onSort($event)"
                        @onSearch="onSearch($event)"
                        @onDelete="onDelete($event)"
                    />
                </div>
            </div>
        </div>
    </div>

    <div
        class="modal fade"
        id="deleteModal"
        tabindex="-1"
        aria-labelledby="deleteModalLabel"
        aria-hidden="true"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">
                        Deleting Data
                    </h1>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        Are you sure you want to <strong>delete</strong> this
                        data? This action cannot be undone.
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>
                        <button
                            type="button"
                            class="btn btn-danger"
                            @click="deleteContact"
                        >
                            Confirm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div
        class="modal fade"
        id="successModal"
        tabindex="-1"
        aria-labelledby="successModalLabel"
        aria-hidden="true"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="successModalLabel">
                        success
                    </h1>
                </div>
                <div class="modal-body">Data has been deleted.</div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-primary"
                        data-bs-dismiss="modal"
                    >
                        OK
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Table from "../../components/Table.vue";
import Loader from "../../components/Loader.vue";
import Pagination from "../../components/Pagination.vue";
export default {
    data() {
        return {
            headings: ["Name", "Email", "Action"],
            variables: ["name", "email"],

            contacts: [],

            isLoading: false,

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
        this.getContact();
    },
    methods: {
        getContact() {
            this.isLoading = true;
            const params = [
                `per_page=${this.pagination.perPage}`,
                `page=${this.pagination.page}`,
                `search=${this.search}`,
            ].join("&");

            this.$store
                .dispatch("getData", ["contact", params])
                .then((response) => {
                    this.isLoading = false;
                    this.tickets = response.data;
                    this.metaPagination = response.meta;
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
        deleteContact() {
            $("#deleteModal").modal("hide");
            this.isLoading = true;

            this.$store
                .dispatch("deleteData", ["contact/trash", this.deleteId])
                .then((result) => {
                    this.isLoading = false;
                    this.getContact();
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
        onSearch() {
            setTimeout(() => {
                this.pagination.page = 1;
                this.getContact();
            }, 1200);
        },
        onPageChange(e) {
            this.pagination.page = e;
            this.getContact();
        },
    },
    components: { Table, Loader, Pagination },
};
</script>

<style>
@media (max-width: 576px) {
    .flex-xs-column {
        flex-direction: column !important;
    }

    .flex-xs-column input.form-control {
        width: 70% !important;
    }
}
</style>
