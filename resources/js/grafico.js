document.addEventListener('DOMContentLoaded', function () {
    const estadisticas = document.querySelectorAll('.estadistica');
    estadisticas.forEach(function (estadistica) {
        const id = estadistica.getAttribute('data-id');
        const porcentaje = parseFloat(estadistica.getAttribute('data-porcentaje'));
        const colores = estadistica.getAttribute('data-colores').split(',');
        const icono = estadistica.getAttribute('data-icono');
        const ctx = document.getElementById(id).getContext('2d');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Usado', 'Restante'],
                datasets: [{
                    data: [porcentaje, Math.max(0, 100 - porcentaje)],
                    backgroundColor: colores,
                    borderWidth: 1,
                    borderColor: ['#000000']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '76%',
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: false }
                }
            }
        });

        const iconoElemento = estadistica.querySelector('.icono-centro i');
        if (iconoElemento) {
            iconoElemento.className = `fa-solid ${icono}`;
        }
    });
});
