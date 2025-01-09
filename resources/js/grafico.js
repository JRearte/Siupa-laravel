document.addEventListener('DOMContentLoaded', function () {
    const estadisticas = document.querySelectorAll('.estadistica');
    estadisticas.forEach(function (estadistica) {
        const id = estadistica.getAttribute('data-id');
        const porcentaje = parseFloat(estadistica.getAttribute('data-porcentaje'));
        const ctx = document.getElementById(id).getContext('2d');

        new Chart(ctx, {
            type: 'doughnut',  // Gráfico de rosca
            data: {
                labels: ['Usado', 'Restante'],
                datasets: [{
                    data: [porcentaje, 100 - porcentaje],
                    backgroundColor: ['#83fe00', '#FAD7A0'],
                    borderWidth: 1,
                    borderColor: ['#000000']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '76%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: false
                    }
                }
            }
        });
    });
});
