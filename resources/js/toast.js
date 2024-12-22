document.addEventListener('DOMContentLoaded', function () {
    const successToast = document.getElementById('toastSuccess');
    const errorToast = document.getElementById('toastError');

    // Función para mostrar el toast con animación y barra de progreso
    function showToast(toastElement) {
        if (toastElement) {
            toastElement.classList.add('show'); // Aparece con animación
            toastElement.style.display = 'flex'; // Asegura que se muestre
            setTimeout(() => {
                // Después de 5 segundos, eliminamos el toast
                toastElement.style.display = 'none';
                toastElement.classList.remove('show');
            }, 5000); // Duración del toast (5 segundos)
        }
    }

    // Mostrar notificación de éxito
    if (successToast) {
        showToast(successToast);
    }

    // Mostrar notificación de error
    if (errorToast) {
        showToast(errorToast);
    }
});
