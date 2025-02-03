let deleteBtns = document.querySelectorAll('.deleteUserBtn');

let confirmDeleteBtn = document.getElementById("confirm-delete");
let formToDelete = document.getElementById("formToDelete");
let urlToConfirmDelete = "";

for (const deleteBtn of deleteBtns) {
    deleteBtn.addEventListener("click", () => {
        document.getElementById('deleteModalLabel').textContent = "Delete sentence";
        document.getElementById('deleteModalBody').textContent = "Are you sure you want to delete this user with email: " + deleteBtn.dataset.email + " and the role: " + deleteBtn.dataset.role;

        confirmDeleteBtn.dataset.id = deleteBtn.dataset.id;

        urlToConfirmDelete = "/" + deleteBtn.dataset.id;
    })
}


confirmDeleteBtn.addEventListener("click", (event)=>{
    formToDelete.action = confirmDeleteBtn.dataset.href + urlToConfirmDelete;
    formToDelete.submit();
});
