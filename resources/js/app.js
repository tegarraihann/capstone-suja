import "./bootstrap";
import axios from "axios";

document.addEventListener("DOMContentLoaded", function () {
    setupAddIndikatorButton();
    setupDeleteSasaranButton();
    setupEditSasaranButton();
    setupAddSasaranButton();
    setupDeleteTujuanButton();
    setupEditTujuanButton();
    setupAddTujuanButton();
    setupLogoutButtons();
    highlightActiveMenuItem();
    applyFiltersFromURL();
    setupDropdownLists();
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
    document.querySelectorAll(".add-tujuan").forEach((btn) => {
        btn.addEventListener("click", function () {
            const iku = this.dataset.iku;
            const text = this.dataset.text;
            swal({
                text: "Tambahkan Tujuan di " + text,
                content: "input",
                buttons: {
                    cancel: true,
                    confirm: {
                        text: "Tambah",
                        closeModal: false,
                    },
                },
            }).then((value) => {
                if (value === null) {
                    return;
                }

                if (!value) {
                    swal({
                        icon: "error",
                        title: "Failed Added",
                        text: "Tujuan tidak boleh kosong",
                    });
                    return;
                }

                const data = {
                    tujuan: value,
                    iku: iku,
                };
                axios
                    .post("/adminbinagram/dashboard/store", data)
                    .then((response) => {
                        swal({
                            icon: "success",
                            title: "Successfully Added",
                            text: "Data tujuan berhasil dimasukkan",
                        }).then(() => {
                            window.location.href = "/adminbinagram/dashboard";
                        });
                    })
                    .catch((error) => {
                        swal({
                            icon: "error",
                            title: "Failed Added",
                            text: "Gagal memasukkan data tujuan",
                        });
                    });
            });
        });
    });
}

function setupEditTujuanButton() {
    document.querySelectorAll(".edit-tujuan").forEach((btn) =>
        btn.addEventListener("click", function () {
            const id = this.dataset.id;
            const currentTujuan = this.dataset.tujuan;

            swal({
                text: "Edit Tujuan",
                content: {
                    element: "input",
                    attributes: {
                        value: currentTujuan,
                    },
                },
                buttons: {
                    cancel: true,
                    confirm: {
                        text: "Update",
                        closeModal: false,
                    },
                },
            }).then((value) => {
                if (value === null) {
                    return;
                }

                if (!value) {
                    swal({
                        icon: "error",
                        title: "Failed Updated",
                        text: "Tujuan tidak boleh kosong",
                    });
                    return;
                }
                if (value) {
                    const data = {
                        tujuan: value,
                    };
                    axios
                        .put(`/adminbinagram/dashboard/update/${id}`, data)
                        .then((response) => {
                            swal({
                                icon: "success",
                                title: "Successfully Updated",
                                text: "Data tujuan berhasil diperbarui",
                            }).then(() => {
                                window.location.href =
                                    "/adminbinagram/dashboard";
                            });
                        })
                        .catch((error) => {
                            swal({
                                icon: "error",
                                title: "Failed Updated",
                                text: "Gagal memperbarui data tujuan",
                            });
                        });
                }
            });
        })
    );
}

function setupDeleteTujuanButton() {
    document.querySelectorAll(".delete-tujuan").forEach((btn) => {
        btn.addEventListener("click", function () {
            const id = this.dataset.id;
            const tujuan = this.dataset.tujuan;

            swal({
                title: "Anda yakin ingin menghapus data ini?",
                text:
                    "[TUJUAN] " +
                    tujuan +
                    "\n\nPerhatian!! Data sasaran, indikator, indikator penunjang, dan sub indikator di tujuan ini juga akan terhapus!",
                icon: "warning",
                buttons: ["Cancel", "Hapus"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios
                        .delete(`/adminbinagram/dashboard/delete/${id}`)
                        .then((response) => {
                            swal({
                                icon: "success",
                                title: "Succesfully Deleted",
                                text: "Data tujuan berhasil dihapus",
                            }).then(() => {
                                window.location.reload();
                            });
                        })
                        .catch((error) => {
                            swal({
                                icon: "error",
                                title: "Failed Deleted",
                                text: "Gagal menghapus data tujuan",
                            });
                        });
                }
            });
        });
    });
}

function setupAddSasaranButton() {
    document.querySelectorAll(".add-sasaran").forEach((btn) => {
        btn.addEventListener("click", function () {
            const tujuanId = this.dataset.tujuanId;
            const text = this.dataset.text;
            swal({
                text: "Tambahkan Sasaran di " + text,
                content: "input",
                buttons: {
                    cancel: true,
                    confirm: {
                        text: "Tambah",
                        closeModal: false,
                    },
                },
            }).then((value) => {
                if (value === null) {
                    return;
                }

                if (!value) {
                    swal({
                        icon: "error",
                        title: "Failed Added",
                        text: "Sasaran tidak boleh kosong",
                    });
                    return;
                }

                const data = {
                    sasaran: value,
                    tujuan_id: tujuanId,
                };

                axios
                    .post("/adminbinagram/dashboard/store", data)
                    .then((response) => {
                        swal({
                            icon: "success",
                            title: "Successfully Added",
                            text: "Data sasaran berhasil dimasukkan",
                        }).then(() => {
                            window.location.href = "/adminbinagram/dashboard";
                        });
                    })
                    .catch((error) => {
                        swal({
                            icon: "error",
                            title: "Failed Added",
                            text: "Gagal memasukkan data sasaran",
                        });
                    });
            });
        });
    });
}

function setupEditSasaranButton() {
    document.querySelectorAll(".edit-sasaran").forEach((btn) => {
        btn.addEventListener("click", function () {
            const id = this.dataset.id;
            const currentSasaran = this.dataset.sasaran;

            swal({
                text: "Edit Sasaran",
                content: {
                    element: "input",
                    attributes: {
                        value: currentSasaran,
                    },
                },
                buttons: {
                    cancel: true,
                    confirm: {
                        text: "Update",
                        closeModal: false,
                    },
                },
            }).then((value) => {
                if (value === null) {
                    return;
                }

                if (!value) {
                    swal({
                        icon: "error",
                        title: "Failed Updated",
                        text: "Sasaran tidak boleh kosong",
                    });
                    return;
                }
                if (value) {
                    const data = {
                        sasaran: value,
                    };
                    axios
                        .put(`/adminbinagram/dashboard/update/${id}`, data)
                        .then((response) => {
                            swal({
                                icon: "success",
                                title: "Successfully Updated",
                                text: "Data sasaran berhasil diperbarui",
                            }).then(() => {
                                window.location.href =
                                    "/adminbinagram/dashboard";
                            });
                        })
                        .catch((error) => {
                            swal({
                                icon: "error",
                                title: "Failed Updated",
                                text: "Gagal memperbarui data sasaran",
                            });
                        });
                }
            });
        });
    });
}

function setupDeleteSasaranButton() {
    document.querySelectorAll(".delete-sasaran").forEach((btn) => {
        btn.addEventListener("click", function () {
            const id = this.dataset.id;
            const sasaran = this.dataset.sasaran;

            swal({
                title: "Anda yakin ingin menghapus data ini?",
                text:
                    "[SASARAN] " +
                    sasaran +
                    "\n\nPerhatian!! Data indikator, indikator penunjang, dan sub indikator di sasaran ini juga akan terhapus!",
                icon: "warning",
                buttons: ["Cancel", "Hapus"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios
                        .delete(`/adminbinagram/dashboard/delete/${id}`, {
                            data: { is_sasaran: true },
                        })
                        .then((response) => {
                            swal({
                                icon: "success",
                                title: "Successfully Deleted",
                                text: "Data sasaran berhasil dihapus",
                            }).then(() => {
                                window.location.reload();
                            });
                        })
                        .catch((error) => {
                            swal({
                                icon: "error",
                                title: "Failed Deleted",
                                text: "Gagal menghapus data sasaran",
                            });
                        });
                }
            });
        });
    });
}

function setupAddIndikatorButton() {
    document.querySelectorAll(".add-indikator").forEach((btn) => {
        btn.addEventListener("click", function () {
            const sasaranId = this.dataset.sasaranId;
            const text = this.dataset.text;

            swal({
                text: "Tambahkan Indikator di " + text,
                content: {
                    element: "div",
                    attributes: {
                        innerHTML: `
                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                <div style="display: flex; flex-direction: column; align-items: start; gap: 5px">
                                    <label for="indikator">Indikator:</label>
                                    <input id="input1" class="swal-content__input" placeholder="Wajib diisi" style="flex-grow: 1;">
                                </div>
                                <div style="display: flex; flex-direction: column; align-items: start; gap: 5px">
                                    <label for="indikator_penunjang">Indikator Penunjang:</label>
                                    <input id="input2" class="swal-content__input" placeholder="Boleh kosong" style="flex-grow: 1;">
                                </div>
                                <div style="display: flex; flex-direction: column; align-items: start; gap: 5px">
                                    <label for="sub_indikator">Sub Indikator:</label>
                                    <input id="input3" class="swal-content__input" placeholder="Boleh kosong" style="flex-grow: 1;">
                                </div>
                                <div style="display: flex; flex-direction: column; align-items: start; gap: 5px">
                                    <p>Jika terdapat data indikator penunjang atau sub indikator, mohon untuk langsung diinputkan</p>
                                </div>
                            </div>
                        `,
                    },
                },
                buttons: {
                    cancel: true,
                    confirm: {
                        text: "Tambah",
                        closeModal: false,
                    },
                },
            }).then((value) => {
                if (value === null) {
                    return;
                }

                const input1 = document.getElementById("input1").value.trim();
                const input2 = document.getElementById("input2").value.trim() || null;
                const input3 = document.getElementById("input3").value.trim() || null;

                if (!input1) {
                    swal({
                        icon: "error",
                        title: "Failed Added",
                        text: "Indikator tidak boleh kosong",
                    });
                    return;
                }

                const data = {
                    indikator: input1,
                    indikator_penunjang: input2 === "" ? null : input2,
                    sub_indikator: input3 === "" ? null : input3,
                    sasaran_id: sasaranId,
                };

                axios
                    .post("/adminbinagram/dashboard/store", data)
                    .then((response) => {
                        swal({
                            icon    : "success",
                            title: "Successfully Added",
                            text: "Data berhasil dimasukkan",
                        }).then(() => {
                            window.location.href = "/adminbinagram/dashboard";
                        });
                    })
                    .catch((error) => {
                        swal({
                            icon: "error",
                            title: "Failed Added",
                            text: "Gagal memasukkan data",
                        });
                    });
            });
        });
    });
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
