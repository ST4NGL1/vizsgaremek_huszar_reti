document.getElementById("registrationForm").addEventListener("submit", async (event) => {
    event.preventDefault();

    const formData = new FormData(event.target);
    const response = await fetch("../pages/register.php", {
        method: "POST",
        body: formData,
    });

    const result = await response.json();

    // Display toast
    const toastContainer = document.getElementById("toast-container");
    const toast = document.createElement("div");
    toast.className = `toast align-items-center text-white border-0 ${result.success ? 'bg-success' : 'bg-danger'}`;
    toast.role = "alert";
    toast.style.width="100%";
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">${result.message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>`;
    toastContainer.appendChild(toast);

    const bootstrapToast = new bootstrap.Toast(toast, { delay: 3000 });
    bootstrapToast.show();

    setTimeout(() => {
        toast.remove();
    }, 3000);
});
