document.addEventListener('DOMContentLoaded', function () {
    const successToast = document.getElementById('toastSuccess');
    const infoToast = document.getElementById('toastInfo');
    const errorToast = document.getElementById('toastError');

    function showToast(toastElement) {
        if (toastElement) {
            toastElement.classList.add('show');
            toastElement.style.display = 'flex';
            setTimeout(() => {
               
                toastElement.style.display = 'none';
                toastElement.classList.remove('show');
            }, 5000);
        }
    }

    if (successToast) {
        showToast(successToast);
    }

    if (infoToast) {
        showToast(infoToast);
    }

    if (errorToast) {
        showToast(errorToast);
    }
});
