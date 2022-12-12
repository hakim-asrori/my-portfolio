<template>
    <Back :route="'project'" :title="'Detail Project'" />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <Loader v-if="isLoading" />

                <div class="card-body">
                    <div class="mb-3">
                        <label>Project Name</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="project.projectName"
                        />
                    </div>
                    <div class="mb-3">
                        <label>Project Domain</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="project.projectDomain"
                        />
                    </div>
                    <div class="mb-3">
                        <label>Project Status</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="project.projectStatus"
                        />
                    </div>
                    <div class="mb-3">
                        <label>Project Description</label>
                        <textarea
                            class="form-control"
                            rows="5"
                            v-model="project.projectDescription"
                        ></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Project Document</label>
                        <div class="d-flex flex-column flex-md-row gap-2">
                            <div
                                class="mb-3 col-lg-6 text-center"
                                style="cursor: pointer"
                                id="customFileInput"
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

                                <span class="error" v-if="errors.document">{{
                                    errors.document
                                }}</span>
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
            </div>
        </div>
    </div>
</template>

<script>
import Back from "../../components/Back.vue";
import Loader from "../../components/Loader.vue";
import CheckExtension from "../../store/services/checkExtension";

export default {
    props: ["id"],
    data() {
        return {
            isLoading: false,

            project: {},
            errors: {},

            newDocuments: [],
            previewNewDocuments: [],
        };
    },
    mounted() {
        this.getProject();
    },
    methods: {
        getProject() {
            this.isLoading = true;
            this.$store
                .dispatch("showData", ["project", this.id])
                .then((response) => {
                    this.isLoading = false;
                    this.project = response.data;
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
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
    components: { Back, Loader },
};
</script>

<style>
#customFileInput {
    padding: 30px;
    border-radius: 5px;
    border: 2px dashed #ced4da;
}
</style>
