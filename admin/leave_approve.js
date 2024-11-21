document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".approve-btn").forEach(button => {
        button.addEventListener("click", function () {
            processLeaveRequest(this.dataset.id, "Approved");
        });
    });

    document.querySelectorAll(".deny-btn").forEach(button => {
        button.addEventListener("click", function () {
            processLeaveRequest(this.dataset.id, "Denied");
        });
    });
});

function processLeaveRequest(id, status) {
    fetch("process_approve.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `id=${id}&status=${status}`
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        location.reload();
    })
    .catch(error => console.error("Error:", error));
}
