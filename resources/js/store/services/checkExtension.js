export default {
    imageExtension(file) {
        const allowedExtensions = ["image/jpg", "image/png", "image/jpeg"];
        if (allowedExtensions.includes(file.type)) {
            return true;
        } else {
            return false;
        }
    },
};
