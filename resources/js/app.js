import "./bootstrap";
import axios from "axios";

document.addEventListener("DOMContentLoaded", function () {
    const logoutButton = document.querySelector(
        ".fa-solid.fa-arrow-right-from-bracket"
    );
    logoutButton.addEventListener("click", function () {
        swal({
                title: "Apakah anda ingin keluar?",
                icon: "warning",
                buttons: {
                    confirm: {
                        text: "Iya",
                        value: true,
                        visible: true,
                        className: "swal-button--confirm",
                        closeModal: true
                    },
                    cancel: {
                        text: "Tidak",
                        value: null,
                        visible: true,
                        className: "",
                        closeModal: true,
                    }
                },
            dangerMode: false,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.pathname = "/logout";
            }
        });
    });

    const links = document.querySelectorAll("a.menu-item");

    links.forEach((link) =>
        link.getAttribute("href") === window.location.pathname
            ? link
                  .querySelector("div")
                  .classList.add("bg-blue-50", "text-blue-600")
            : link
                  .querySelector("div")
                  .classList.remove("bg-blue-50", "text-blue-600")
    );
});

document.addEventListener("DOMContentLoaded", function () {
    const logoutButton = document.querySelectorAll(".btn-delete");

    logoutButton.forEach((btn) =>
        btn.addEventListener("click", function () {
            const nip = this.dataset.nip;
            const name = this.dataset.name;
            const id = this.dataset.id;
            swal({
                title: "Apakah ingin menghapus user ini?",
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

    editIcons.forEach(icon => {
        icon.addEventListener('click', function () {
            const userId = this.dataset.id;
            window.location.href = `/adminsistem/dashboard/edit-user/${userId}`;
        });
    });
});
