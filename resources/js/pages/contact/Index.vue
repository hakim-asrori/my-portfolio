<template>
    <h1 class="h3 mb-3">Contacts</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs">
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
                    </ul>
                </div>
                <Loader v-if="isLoading" />

                <div class="card-body">
                    <div class="d-flex justify-content-between flex-md-row flex-xs-column align-items-center">
                        <input type="search" class="form-control" style="width: 30%; margin-top: -10px;" @keyup="onSearch" v-model="search">

                        <Pagination :pagination="metaPagination" @onPageChange="onPageChange($event)" />
                    </div>

                    <Table
                        :feature="'admin/contact'"
                        :isShow="true"
                        :isPaginate="true"
                        :isSort="false"
                        :isSearch="true"
                        :numeric="false"
                        :headings="headings"
                        :data="tickets"
                        :variables="variables"
                        @onSort="onSort($event)"
                        @onSearch="onSearch($event)"
                    />
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
                `search=${this.search}`
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

        onSort(e) {
            this.pagination.perPage = e;
            this.getContact();
        },
        onSearch() {
            this.getContact();
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
        flex-direction: column!important;
    }

    .flex-xs-column input.form-control {
        width: 70% !important;
    }
}
</style>
