<template>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">
                        <div class="text-center mt-4">
                            <h1 class="h2">Welcome back, Hakim Asrori</h1>
                            <p class="lead">
                                Sign in to your account to continue
                            </p>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <form
                                        method="post"
                                        @submit.prevent="handleSubmit"
                                    >
                                        <div class="mb-3">
                                            <label class="form-label"
                                                >Email</label
                                            >
                                            <input
                                                class="form-control form-control-lg"
                                                type="email"
                                                name="email"
                                                placeholder="Enter your email"
                                                v-model="form.email"
                                            />
                                            <div
                                                v-if="errors"
                                                v-for="(
                                                    error, index
                                                ) in errors.email"
                                                :key="index"
                                                class="error"
                                            >
                                                {{ error }}
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"
                                                >Password</label
                                            >
                                            <input
                                                class="form-control form-control-lg"
                                                type="password"
                                                name="password"
                                                placeholder="Enter your password"
                                                v-model="form.password"
                                            />
                                            <div
                                                v-if="errors"
                                                v-for="(
                                                    error, index
                                                ) in errors.password"
                                                :key="index"
                                                class="error"
                                            >
                                                {{ error }}
                                            </div>
                                        </div>
                                        <div class="text-center mt-3">
                                            <button
                                                type="submit"
                                                class="btn btn-lg btn-primary"
                                            >
                                                Sign in
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div
        class="modal fade"
        id="exampleModal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Modal title
                    </h1>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">...</div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>
                    <button type="button" class="btn btn-primary">
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                email: "",
                password: "",
            },
            errors: {},
        };
    },
    methods: {
        handleSubmit() {
            this.$store
                .dispatch("postData", ["auth/login", this.form])
                .then((result) => {
                    console.log(result);
                })
                .catch((err) => {
                    this.errors = err.response.data.errors;
                });
        },
    },
};
</script>
