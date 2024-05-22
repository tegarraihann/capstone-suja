import "./bootstrap";

document.addEventListener("DOMContentLoaded", function () {
    handleProfilePopUp();
    setupLogoutButtons();
    highlightActiveMenuItem();
    applyFiltersFromURL();
    setupDropdownLists();
    setupAddTujuanButton();
    setupDeleteButtons();
    setupEditButtons();
    setupTableSearch();
});

function setupLogoutButtons() {
    document.querySelectorAll(".logout-btn").forEach((btn) =>
        btn.addEventListener("click", function () {
            swal({
                title: "Apakah anda ingin keluar?",
                icon: "warning",
                buttons: {
                    confirm: {
                        text: "Iya",
                        value: true,
                        visible: true,
                        className: "swal-button--confirm",
                        closeModal: true,
                    },
                    cancel: {
                        text: "Tidak",
                        value: null,
                        visible: true,
                        className: "",
                        closeModal: true,
                    },
                },
                dangerMode: false,
            }).then((willDelete) => {
                if (willDelete) {
                    window.location.pathname = "/logout";
                }
            });
        })
    );
}

function highlightActiveMenuItem() {
    const links = document.querySelectorAll("a.menu-item");
    links.forEach((link) =>
        window.location.pathname.includes(link.getAttribute("href"))
            ? link
                  .querySelector("div")
                  .classList.add("bg-blue-50", "text-blue-600")
            : link
                  .querySelector("div")
                  .classList.remove("bg-blue-50", "text-blue-600")
    );
}

function applyFiltersFromURL() {
    const params = new URLSearchParams(window.location.search);
    document
        .querySelectorAll("select.filter-select option")
        .forEach(
            (opt) =>
                opt.getAttribute("value") === params.get("filter") &&
                opt.setAttribute("selected", true)
        );
    document
        .querySelectorAll("select.sort-order option")
        .forEach(
            (sort) =>
                sort.getAttribute("value") === params.get("sort_order") &&
                sort.setAttribute("selected", true)
        );
}

function setupDropdownLists() {
    document.querySelectorAll(".parent .btn").forEach((parentBtn) => {
        parentBtn.addEventListener("click", function () {
            const childUl = this.parentNode.nextElementSibling;
            if (childUl && childUl.classList.contains("child")) {
                childUl.classList.contains("hidden")
                    ? expand(childUl, this)
                    : collapseAll(childUl, this);
            }
        });
    });
}

function collapseAll(element, parentBtn) {
    element.classList.add("hidden");
    parentBtn.classList.remove("fa-minus");
    parentBtn.classList.add("fa-plus");

    element.querySelectorAll(".child").forEach((child) => {
        child.classList.add("hidden");
        const childBtn = child.previousElementSibling.querySelector(".btn");
        if (childBtn) {
            childBtn.classList.remove("fa-minus");
            childBtn.classList.add("fa-plus");
        }
    });
}

function expand(element, parentBtn) {
    element.classList.remove("hidden");
    parentBtn.classList.remove("fa-plus");
    parentBtn.classList.add("fa-minus");
}

function setupAddTujuanButton() {
    document.querySelectorAll(".add-tujuan").forEach((btn) =>
        btn.addEventListener("click", function () {
            swal({
                text: "Tambahkan Tujuan baru",
                content: "input",
                buttons: {
                    cancel: true,
                    confirm: {
                        text: "Tambah",
                        closeModal: false,
                    },
                },
            }).then(() => {
                // Add your logic here
            });
        })
    );
}

function setupDeleteButtons() {
    document.querySelectorAll(".btn-delete").forEach((btn) =>
        btn.addEventListener("click", function () {
            const { nip, name, id } = this.dataset;
            swal({
                title: "Apakah anda ingin menghapus user ini?",
                text: `Nama: ${name}\nNIP: ${nip}`,
                icon: "warning",
                buttons: {
                    confirm: {
                        text: "Hapus",
                        value: true,
                        visible: true,
                        className: "swal-button--confirm",
                        closeModal: true,
                    },
                    cancel: {
                        text: "Tidak",
                        value: null,
                        visible: true,
                        className: "",
                        closeModal: true,
                    },
                },
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios.delete(`/adminsistem/dashboard/${id}`).then(() => {
                        swal({
                            icon: "success",
                            title: "User Delete Successfully",
                            text: "Akun berhasil dihapus",
                        }).then(() => {
                            window.location.reload();
                        });
                    });
                }
            });
        })
    );
}

function setupEditButtons() {
    document.querySelectorAll(".btn-update").forEach((icon) =>
        icon.addEventListener("click", function () {
            const userId = this.dataset.id;
            window.location.href = `/adminsistem/edit-user/${userId}`;
        })
    );
}

function setupTableSearch() {
    document
        .getElementById("table-search")
        .addEventListener("input", function (event) {
            const searchQuery = event.target.value;
            const url = new URL(window.location);
            url.searchParams.set("search", searchQuery);
            window.history.pushState({}, "", url);
        });
}

function handleProfilePopUp() {
    const profileBtn = document.querySelector(".profile-btn");
    const profileContainer = document.getElementById("profile-container");

    profileBtn.addEventListener("click", (event) => {
        event.stopPropagation(); // Prevent the click from bubbling up to the document
        profileContainer.classList.toggle("hidden");
    });

    document.addEventListener("click", (event) => {
        if (
            !profileContainer.classList.contains("hidden") &&
            !profileContainer.contains(event.target) &&
            !profileBtn.contains(event.target)
        ) {
            profileContainer.classList.add("hidden");
        }
    });
}
