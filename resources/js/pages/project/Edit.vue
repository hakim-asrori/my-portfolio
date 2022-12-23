<template>
    <Back :route="'project'" :title="'Edit Project'" />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <Loader v-if="isLoading" />

                <form @submit.prevent="handleSubmit" method="post">
                    <div class="card-body">
                        <div class="mb-3">
                            <label :class="{ error: errors.projectName }"
                                >Project Name</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                v-model="project.projectName"
                                :class="{ 'is-invalid': errors.projectName }"
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
                                v-model="project.projectDomain"
                                :class="{ 'is-invalid': errors.projectDomain }"
                            />
                            <Errors
                                v-if="errors.projectDomain"
                                :errors="errors.projectDomain"
                            />
                        </div>
                        <div class="mb-3">
                            <label :class="{ error: errors.projectDescription }"
                                >Project Description</label
                            >
                            <!-- <textarea
                                class="form-control"
                                rows="5"
                                :class="{
                                    'is-invalid': errors.projectDescription,
                                }"
                                v-model="project.projectDescription"
                            ></textarea> -->
                            <ckeditor
                                v-model="project.projectDescription"
                                :config="editorConfig"
                                :editor="editor"
                            />
                            <Errors
                                v-if="errors.projectDescription"
                                :errors="errors.projectDescription"
                            />
                        </div>
                        <div class="mb-3">
                            <label>Project Document</label>
                            <div class="d-flex flex-column flex-md-row gap-2">
                                <div
                                    class="mb-3 col-lg-6 text-center"
                                    style="cursor: pointer"
                                    id="customFileInput"
                                    @click="handleUpload"
                                    :class="{
                                        'is-invalid error': errors.documents,
                                    }"
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
                                    <div
                                        style="width: 100px; height: 100px"
                                        class="d-flex justify-content-end"
                                        v-if="project.documents"
                                        v-for="(
                                            document, index
                                        ) in project.documents"
                                        :key="index"
                                    >
                                        <span
                                            class="btn btn-danger btn-sm position-absolute cursor"
                                            @click="removeOldDocument(index)"
                                            >&times;</span
                                        >
                                        <img
                                            alt=""
                                            :src="document.documentPath"
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
                        <div class="mb-3">
                            <label>Project Status</label>
                            <div class="form-check form-switch">
                                <input
                                    class="form-check-input bg-danger"
                                    type="checkbox"
                                    role="switch"
                                    id="project-status"
                                    v-model="project.projectStatus"
                                    :checked="project.projectStatus == 1"
                                    @change="
                                        changeStatus(project.projectStatus)
                                    "
                                />
                                <label
                                    class="form-check-label"
                                    for="project-status"
                                    v-html="status"
                                ></label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button class="btn btn-sm btn-primary">
                            Save Project
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
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

export default {
    props: ["id"],
    data() {
        return {
            isLoading: false,

            project: {},
            errors: {},
            status: "Inactive",

            oldDocuments: [],

            newDocuments: [],
            previewNewDocuments: [],

            errors: {},

            editor: ClassicEditor,
            editorData: "",
            editorConfig: {
                toolbar: [
                    "heading",
                    "|",
                    "bold",
                    "italic",
                    "link",
                    "bulletedList",
                    "numberedList",
                    "blockQuote",
                    "insertTable",
                    "undo",
                    "redo",
                ],
            },
        };
    },
    mounted() {
        this.getProject();
    },
    computed: {
        formData() {
            let formData = new FormData();
            formData.append("project_name", this.project.projectName);
            formData.append("project_domain", this.project.projectDomain);
            formData.append(
                "project_description",
                this.project.projectDescription
            );

            this.newDocuments.forEach((document, index) => {
                formData.append("documents[" + index + "]", document);
            });

            this.oldDocuments.forEach((document, index) => {
                formData.append("old_documents[" + index + "]", document.id);
            });

            let status = 0;
            if (this.project.projectStatus) {
                status = 1;
            }

            formData.append("project_status", status);
            formData.append("_method", "PUT");

            return formData;
        },
    },
    methods: {
        getProject() {
            this.isLoading = true;
            this.$store
                .dispatch("showData", ["project", this.id])
                .then((response) => {
                    this.isLoading = false;
                    this.project = response.data;
                    this.oldDocuments = response.data.documents;

                    if (response.data.projectStatus == 1) {
                        this.status = "Active";
                        $("#project-status")
                            .addClass("bg-success")
                            .removeClass("bg-danger");
                    }
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
        handleSubmit() {
            console.log(this.formData);
            this.isLoading = true;
            this.$store
                .dispatch("postDataUpload", [
                    this.formData,
                    "/project/" + this.id,
                ])
                .then((response) => {
                    this.isLoading = false;
                    this.message = "project has been updated";
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
        removeOldDocument(index) {
            this.project.documents.splice(index, 1);
        },
        handleUpload() {
            $("#fileInput").click();
        },
        changeStatus(status) {
            if (status) {
                this.status = "Active";
                $("#project-status")
                    .addClass("bg-success")
                    .removeClass("bg-danger");
            } else {
                this.status = "Inactive";
                $("#project-status")
                    .addClass("bg-danger")
                    .removeClass("bg-success");
            }
        },
    },
    components: { Back, Loader, SuccessModal, Errors },
};
</script>

<style>
#customFileInput {
    padding: 30px;
    border-radius: 5px;
    border: 2px dashed #ced4da;
}
</style>
