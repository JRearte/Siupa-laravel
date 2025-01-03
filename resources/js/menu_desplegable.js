document.querySelectorAll('.dropbtn').forEach(button => {
    button.addEventListener('click', function () {
        const dropdownContent = this.nextElementSibling;

        // Alternar la clase "show"
        dropdownContent.classList.toggle('show');

        // Alternar la clase "selected" en el botón (para cambiar color)
        this.classList.toggle('selected');

        // Cerrar otros dropdowns abiertos (opcional)
        document.querySelectorAll('.dropdown-content').forEach(content => {
            if (content !== dropdownContent) {
                content.classList.remove('show');
            }
        });

        // Eliminar la clase "selected" de otros botones (opcional)
        document.querySelectorAll('.dropbtn').forEach(otherButton => {
            if (otherButton !== this) {
                otherButton.classList.remove('selected');
            }
        });
    });
});

// Cerrar el menú si se hace clic fuera
document.addEventListener('click', function (event) {
    if (!event.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown-content').forEach(content => {
            content.classList.remove('show');
        });

        // Eliminar la clase "selected" de todos los botones al hacer clic fuera
        document.querySelectorAll('.dropbtn').forEach(button => {
            button.classList.remove('selected');
        });
    }
});

