<template>
    <div class="wrapper">
        <Sidebar />
        <div class="main">
            <Navbar :user="user" />
            <main class="content">
                <div class="container-fluid p-0">
                    <router-view></router-view>
                </div>
            </main>
            <Footer />
        </div>
    </div>
</template>

<script>
import Sidebar from "./components/layouts/Sidebar.vue";
import Navbar from "./components/layouts/Navbar.vue";
import Footer from "./components/layouts/Footer.vue";

import Cookie from "js-cookie";

export default {
    components: { Sidebar, Navbar, Footer },
    data() {
        return {
            user: {},
        };
    },
    watch: {
        "$route.params.search": {
            handler: function (search) {
                this.$store
                    .dispatch("getData", ["/auth/check", {}])
                    .then((response) => {
                        this.user = response.data;
                    })
                    .catch((error) => {
                        console.log(error);
                        this.error = error.response.data;
                        Cookie.remove("token");
                        window.location.replace("");
                    });

                if (Cookie.get("token") == undefined) {
                    window.location.replace("");
                }
            },
            deep: true,
            immediate: true,
        },
    },
};
</script>
