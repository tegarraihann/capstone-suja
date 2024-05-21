import "./bootstrap";
import axios from "axios";

document.addEventListener("DOMContentLoaded", function () {
    const logoutButton = document.querySelectorAll(
        ".logout-btn"
    );
    logoutButton.forEach(btn => (btn.addEventListener("click", function () {
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
    })))

    // for sidebar menu
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

    // filter table
    const params = new URLSearchParams(window.location.search)
    const filterOptions = document.querySelectorAll('select.filter-select option')
    const sortOrders = document.querySelectorAll('select.sort-order option')
    filterOptions.forEach(
        (opt) => opt.getAttribute("value") === params.get("filter") && opt.setAttribute("selected", true)
    )
    sortOrders.forEach(
        (sort) => sort.getAttribute("value") === params.get("sort_order") && sort.setAttribute("selected", true)
    )

    // dropdown list IKU

    document.querySelectorAll('.parent .btn').forEach(parent => {
        parent.addEventListener('click', function() {
            let childUl = this.parentNode.nextElementSibling;
            if (childUl && childUl.classList.contains('child')) {
                childUl.classList.toggle('hidden');
                if (childUl.classList.contains('hidden')) {
                    parent.classList.toggle('fa-minus')
                    parent.classList.toggle('fa-plus')
                } else {
                    parent.classList.toggle('fa-minus')
                    parent.classList.toggle('fa-plus')
                }
            }
        });
    });
    
});

document.addEventListener("DOMContentLoaded", function () {
    const logoutButton = document.querySelectorAll(".btn-delete");

    logoutButton.forEach((btn) =>
        btn.addEventListener("click", function () {
            const nip = this.dataset.nip;
            const name = this.dataset.name;
            const id = this.dataset.id;
            swal({
                title: "Apakah anda ingin menghapus user ini?",
                text: "Nama: " + name + "\nNIP: " + nip,
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
                    axios
                        .delete("/adminsistem/dashboard/" + id)
                        .then(function (response) {
                            swal({
                                icon: "success",
                                title: "User Delete Succesfully",
                                text: "Akun berhasil dihapus",
                            }).then(function (response) {
                                window.location.reload();
                            });
                        });
                }
            });
        })
    );
});

document.addEventListener("DOMContentLoaded", function () {
    const editIcons = document.querySelectorAll(".btn-update");

    editIcons.forEach((icon) => {
        icon.addEventListener("click", function () {
            const userId = this.dataset.id;
            window.location.href = `/adminsistem/edit-user/${userId}`;
        });
    });
});

document
    .getElementById("table-search")
    .addEventListener("input", function (event) {
        const searchQuery = event.target.value;
        const url = new URL(window.location);
        url.searchParams.set("search", searchQuery);
        window.history.pushState({}, "", url);
    });
