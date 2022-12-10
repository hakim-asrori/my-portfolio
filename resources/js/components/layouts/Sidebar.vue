<template>
    <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">
            <a class="sidebar-brand" href="index.html">
                <span class="align-middle">My Portofolio</span>
            </a>

            <ul class="sidebar-nav">
                <li class="sidebar-header">Dashboard</li>

                <li class="sidebar-item">
                    <router-link class="sidebar-link" to="/home">
                        <i class="align-middle" data-feather="sliders"></i>
                        <span class="align-middle">Home</span>
                    </router-link>
                </li>

                <li class="sidebar-item">
                    <router-link class="sidebar-link" to="/about">
                        <i class="align-middle" data-feather="user"></i>
                        <span class="align-middle">About</span>
                    </router-link>
                </li>

                <li class="sidebar-header">Others</li>

                <li class="sidebar-item">
                    <router-link class="sidebar-link" to="/contact">
                        <i
                            class="align-middle"
                            data-feather="message-square"
                        ></i>
                        <span class="align-middle">Contact</span>
                    </router-link>
                </li>

                <li class="sidebar-item">
                    <router-link class="sidebar-link" to="/project">
                        <i class="align-middle" data-feather="package"></i>
                        <span class="align-middle">Project</span>
                    </router-link>
                </li>

                <li class="sidebar-item">
                    <router-link class="sidebar-link" to="/blog">
                        <i class="align-middle" data-feather="book"></i>
                        <span class="align-middle">Blog</span>
                    </router-link>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script></script>
