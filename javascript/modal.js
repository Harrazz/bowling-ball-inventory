function openModal(id) {
    document.getElementById(id).style.display = "block";
}

function closeModal(id) {
    document.getElementById(id).style.display = "none";
}

// Optional: Close modal when clicking outside of it
window.onclick = function (event) {
    const modals = ['addModal', 'editModal', 'deleteModal'];
    modals.forEach(modalID => {
        const modal = document.getElementById(modalID);
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
}

