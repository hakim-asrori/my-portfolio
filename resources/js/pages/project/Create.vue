<template>
    <Back :route="'project'" :title="'Create Project'" />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <Loader v-if="isLoading" />

                <form method="post" @submit.prevent="handleSubmit">
                    <div class="card-body">
                        <div class="mb-3">
                            <label :class="{ error: errors.projectName }"
                                >Project Name</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                :class="{ 'is-invalid': errors.projectName }"
                                v-model="form.projectName"
                            />
                            <Errors
                                v-if="errors.projectName"
                                :errors="errors.projectName"
                            />
                        </div>
                        <div class="mb-3">
                            <label :class="{ error: errors.projectDomain }"
                                >Project Domain</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                :class="{ 'is-invalid': errors.projectDomain }"
                                v-model="form.projectDomain"
                            />
                            <Errors
                                v-if="errors.projectDomain"
                                :errors="errors.projectDomain"
                            />
                        </div>
                        <div class="mb-3">
                            <label>Project Status</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="form.projectStatus"
                            />
                        </div>
                        <div class="mb-3">
                            <label :class="{ error: errors.projectDescription }"
                                >Project Description</label
                            >
                            <textarea
                                class="form-control"
                                :class="{
                                    'is-invalid': errors.projectDescription,
                                }"
                                v-model="form.projectDescription"
                                rows="5"
                            ></textarea>
                            <Errors
                                v-if="errors.projectDescription"
                                :errors="errors.projectDescription"
                            />
                        </div>
                        <div class="mb-3">
                            <label :class="{ error: errors.documents }"
                                >Project Document</label
                            >
                            <div class="d-flex flex-column flex-md-row gap-2">
                                <div
                                    class="mb-3 col-lg-6 text-center"
                                    style="cursor: pointer"
                                    id="customFileInput"
                                    :class="{
                                        'is-invalid error': errors.documents,
                                    }"
                                    @click="handleUpload"
                                >
                                    <p>
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
                                            class="feather feather-upload align-middle me-2"
                                        >
                                            <path
                                                d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"
                                            ></path>
                                            <polyline
                                                points="17 8 12 3 7 8"
                                            ></polyline>
                                            <line
                                                x1="12"
                                                y1="3"
                                                x2="12"
                                                y2="15"
                                            ></line>
                                        </svg>
                                    </p>
                                    <p>upload documents in here...</p>
                                    <input
                                        type="file"
                                        multiple
                                        id="fileInput"
                                        @change="chooseDocument"
                                        hidden
                                    />

                                    <span
                                        class="error"
                                        v-if="errors.document"
                                        >{{ errors.document }}</span
                                    >

                                    <Errors
                                        v-if="errors.documents"
                                        :errors="errors.documents"
                                    />
                                </div>
                                <div class="mb-3 col-lg-6 row">
                                    <div
                                        style="width: 100px; height: 100px"
                                        class="d-flex justify-content-end"
                                        v-for="(
                                            document, index
                                        ) in previewNewDocuments"
                                        :key="index"
                                    >
                                        <span
                                            class="btn btn-danger btn-sm position-absolute cursor"
                                            @click="removeNewDocument(index)"
                                            >&times;</span
                                        >
                                        <img
                                            alt=""
                                            :src="document"
                                            src="https://avatars.githubusercontent.com/u/77718626?s=120&v=4"
                                            class="img-thumbnail"
                                            style="
                                                object-fit: cover;
                                                width: 100px;
                                                height: 100px;
                                            "
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <button class="btn btn-sm btn-primary">
                            Add Project
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <SuccessModal :msg="message" :route="'/project'" />
</template>

<script>
import Back from "../../components/Back.vue";
import Errors from "../../components/Errors.vue";
import Loader from "../../components/Loader.vue";
import SuccessModal from "../../components/modals/SuccessModal.vue";
import CheckExtension from "../../store/services/checkExtension";

export default {
    props: ["id"],
    data() {
        return {
            isLoading: false,

            form: {
                projectName: "",
                projectDomain: "",
                projectStatus: "",
                projectDescription: "",
            },

            errors: {},
            message: "",

            newDocuments: [],
            previewNewDocuments: [],
        };
    },
    computed: {
        formData() {
            const formData = new FormData();
            formData.append("project_name", this.form.projectName);
            formData.append("project_domain", this.form.projectDomain);
            formData.append("project_status", this.form.projectStatus);
            formData.append(
                "project_description",
                this.form.projectDescription
            );

            this.newDocuments.forEach((document, index) => {
                formData.append("documents[" + index + "]", document);
            });

            return formData;
        },
    },
    methods: {
        handleSubmit() {
            this.isLoading = true;
            this.$store
                .dispatch("postDataUpload", [this.formData, "project"])
                .then((response) => {
                    this.isLoading = false;
                    this.message = "project has been created";
                    $("#successModal").modal("show");
                })
                .catch((error) => {
                    this.isLoading = false;
                    this.errors = error.response.data.errors;
                });
        },
        chooseDocument(e) {
            const documents = e.target.files;
            this.errors = {};
            this.newDocuments = [];
            for (let i = 0; i < documents.length; i++) {
                if (CheckExtension.imageExtension(documents[i])) {
                    this.newDocuments.push(documents[i]);
                    this.previewNewDocuments.push(
                        URL.createObjectURL(documents[i])
                    );
                } else {
                    this.errors = {
                        document:
                            "The documents must be a file of type: png, jpg, jpeg.",
                    };
                }
            }
        },
        removeNewDocument(index) {
            this.newDocuments.splice(index, 1);
            this.previewNewDocuments.splice(index, 1);
        },
        handleUpload() {
            $("#fileInput").click();
        },
    },
    components: { Back, Loader, Errors, SuccessModal },
};
</script>

<style>
#customFileInput {
    padding: 30px;
    border-radius: 5px;
    border: 2px dashed #ced4da;
}

#customFileInput.is-invalid {
    border: 2px dashed red;
}
</style>
