<template>
    <Loader v-if="isLoading" />
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
                                <div
                                    class="card text-white"
                                    v-if="errorMessage"
                                >
                                    <div class="card-body bg-danger">
                                        {{ errorMessage }}
                                    </div>
                                </div>
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
        id="popUpSuccess"
        tabindex="-1"
        aria-labelledby="popUpSuccessLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="popUpSuccessLabel">
                        {{ successMessage.status }}
                    </h1>
                </div>
                <div class="modal-body">{{ successMessage.message }}</div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="redirectTo"
                    >
                        OK
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Cookies from "js-cookie";
import Loader from "../../components/Loader.vue";

export default {
    data() {
        return {
            form: {
                email: "",
                password: "",
            },
            isLoading: false,
            errors: {},
            errorMessage: "",
            successMessage: {},
        };
    },
    methods: {
        handleSubmit() {
            this.isLoading = true;
            this.$store
                .dispatch("postData", ["auth/login", this.form])
                .then((result) => {
                    this.isLoading = false;
                    this.successMessage = {
                        message: result.message,
                        status: result.status,
                    };
                    Cookies.set("token", result.token);
                    $("#popUpSuccess").modal("show");
                    setTimeout(() => {
                        this.redirectTo();
                    }, 1000);
                })
                .catch((err) => {
                    this.isLoading = false;
                    if (err.response.data.status == "warning") {
                        this.errorMessage = err.response.data.errors;
                    }
                    this.errors = err.response.data.errors;
                });
        },
        redirectTo() {
            location.href = "/";
        },
    },
    components: { Loader },
};
</script>
