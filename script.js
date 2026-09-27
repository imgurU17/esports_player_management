document.addEventListener("DOMContentLoaded", function () {

    const deleteButtons =
        document.querySelectorAll(".delete-btn");

    deleteButtons.forEach(function (button) {

        button.addEventListener("click", function (event) {

            if (!confirm("Are you sure you want to delete this record?")) {
                event.preventDefault();
            }

        });

    });

});