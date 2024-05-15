import './bootstrap';

document.addEventListener('DOMContentLoaded', function() {
    const logoutButton = document.querySelector('.fa-solid.fa-arrow-right-from-bracket');
    logoutButton.addEventListener('click', function() {
        swal({
                title: "Apakah kamu ingin keluar?",
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
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.pathname = '/logout';
                }
            });
    });
});
