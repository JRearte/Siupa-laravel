
document.addEventListener("DOMContentLoaded", function () {
    const botonesEliminar = document.querySelectorAll(".eliminar");

    botonesEliminar.forEach(boton => {
        boton.addEventListener("click", function (event) {
            event.preventDefault();

            document.querySelectorAll(".dropdown-eliminar").forEach(drop => {
                if (drop !== boton.nextElementSibling) {
                    drop.classList.remove("activo");
                }
            });

            const dropdown = boton.nextElementSibling;
            if (dropdown) {
                dropdown.classList.toggle("activo");
            }
        });
    });


    const botonesCancelar = document.querySelectorAll(".cancelar");
    botonesCancelar.forEach(boton => {
        boton.addEventListener("click", function (event) {
            event.preventDefault();
            const dropdown = boton.closest(".dropdown-eliminar");
            if (dropdown) {
                dropdown.classList.remove("activo");
            }
        });
    });


    document.addEventListener("click", function (event) {
        if (!event.target.closest(".eliminar-wrapper")) {
            document.querySelectorAll(".dropdown-eliminar").forEach(drop => {
                drop.classList.remove("activo");
            });
        }
    });
});
