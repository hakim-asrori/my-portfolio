<template>
    <div class="loading-section">
        <div class="custom-loading-circle"></div>
    </div>
</template>

<style>
.loading-section {
    /* style="position:absolute; z-index: 99;" */
    position: absolute;
    transition: all 0.5s ease-in;
    transition-duration: 2s;
    z-index: 99;
    width: 100%;
    height: 100%;
    align-self: center;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(1.5px);
    background-color: rgba(244, 244, 244, 0.15);
    overflow: hidden;
    margin: auto;
}

.custom-loading-circle {
    display: inline-block;
    width: 80px;
    height: 80px;
}

.custom-loading-circle:after {
    content: " ";
    display: block;
    width: 64px;
    height: 64px;
    margin: 8px;
    border-radius: 50%;
    border: 6px solid #fff;
    border-color: #141d3e transparent #141d3e transparent;
    animation: custom-loading-circle 1.2s linear infinite;
}

@keyframes custom-loading-circle {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>
