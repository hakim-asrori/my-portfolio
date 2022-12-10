<template>
    <div class="d-flex align-items-center mb-3">
        <router-link to="/contact" class="text-dark">
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
        <span style="font-size: 1.3125rem" class="ms-3">Detail Contact</span>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <Loader v-if="isLoading" />
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input
                            type="text"
                            v-model="contact.name"
                            class="form-control"
                            disabled
                        />
                    </div>
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input
                            type="text"
                            v-model="contact.email"
                            class="form-control"
                            disabled
                        />
                    </div>
                    <div class="mb-3">
                        <label for="message">Message</label>
                        <textarea class="form-control" disabled rows="5">{{
                            contact.message
                        }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Loader from "../../components/Loader.vue";

export default {
    props: ["id"],
    data() {
        return {
            contact: {},
            isLoading: false,
        };
    },
    mounted() {
        this.getContact();
    },
    methods: {
        getContact() {
            this.isLoading = true;
            this.$store
                .dispatch("showData", ["contact", this.id])
                .then((response) => {
                    this.isLoading = false;
                    this.contact = response.data;
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
    },
    components: { Loader },
};
</script>
