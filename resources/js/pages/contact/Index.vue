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
                    :metaPagination="metaPagination"
                    @onSort="onSort($event)"
                    @onSearch="onSearch($event)"
                    @onPageChange="onPageChange($event)"
                />
            </div>
        </div>
    </div>
</template>

<script>
import Table from "../../components/Table.vue";
import Loader from "../../components/Loader.vue";
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
        onSearch(e) {
            this.search = e;
            this.getContact();
        },
        onPageChange(e) {
            this.pagination.page = e;
            this.getContact();
        },
    },
    components: { Table, Loader },
};
</script>
