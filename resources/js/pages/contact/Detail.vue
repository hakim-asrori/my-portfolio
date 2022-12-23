<template>
    <Back :route="'contact'" :title="'Detail Contact'" />

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
import Back from "../../components/Back.vue";
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
    components: { Loader, Back },
};
</script>
