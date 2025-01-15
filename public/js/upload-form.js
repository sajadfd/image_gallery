document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    if (form) {
        form.addEventListener("submit", function (event) {
            const fileInput = document.getElementById("image");
            const file = fileInput.files[0];

            if (file && file.size > 5 * 1024 * 1024) {
                // 5MB
                alert("File size exceeds 5MB");
                event.preventDefault();
            }
        });
    }
});
