document.addEventListener("DOMContentLoaded", function() {
    const chartElement = document.getElementById('asistenciasChart');
    if (!chartElement) return;

    const datosGrafico = JSON.parse(chartElement.dataset.graficoDatos);
    
    const diasAbreviados = ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"];
    const diasCompletos = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];

    const obtenerDiaSemana = (fechaString, completo = false) => {
        const fecha = new Date(fechaString + "T00:00:00");
        return isNaN(fecha) ? "" : (completo ? diasCompletos[fecha.getUTCDay()] : diasAbreviados[fecha.getUTCDay()]);
    };

    const obtenerColor = (valor, maximo) => {
        const porcentaje = (valor / maximo) * 100;
        if (porcentaje <= 30) return 'rgba(255, 77, 77, 0.7)';
        if (porcentaje <= 50) return 'rgba(255, 165, 0, 0.7)';
        if (porcentaje <= 70) return 'rgba(255, 215, 0, 0.7)';
        if (porcentaje <= 90) return 'rgba(144, 238, 144, 0.7)';
        return 'rgba(0, 128, 0, 0.7)';
    };

    const etiquetasDias = datosGrafico.labels.map((dia, index) => ({
        numero: dia.toString(),
        diaCorto: obtenerDiaSemana(datosGrafico.fechas[index] || ""),
        diaLargo: obtenerDiaSemana(datosGrafico.fechas[index] || "", true),
        fechaCompleta: datosGrafico.fechas[index] || ""
    }));

    const ctx = chartElement.getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: etiquetasDias.map(e => e.numero),
            datasets: [{
                label: 'Asistencias por Día',
                data: datosGrafico.data,
                backgroundColor: datosGrafico.data.map(value => obtenerColor(value, datosGrafico.cantidadInfantes)),
                borderColor: 'rgba(0, 0, 0, 0.2)',
                borderWidth: 1,
                borderRadius: 5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    ticks: {
                        autoSkip: false,
                        maxRotation: 0,
                        minRotation: 0,
                        callback: (value, index) => etiquetasDias[index] ? [`${etiquetasDias[index].numero}`, `${etiquetasDias[index].diaCorto}`] : ""
                    }
                },
                y: {
                    beginAtZero: true,
                    suggestedMax: datosGrafico.cantidadInfantes
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        title: (tooltipItems) => `Día ${etiquetasDias[tooltipItems[0].dataIndex].numero} (${etiquetasDias[tooltipItems[0].dataIndex].diaLargo})`,
                        label: (tooltipItem) => {
                            const valor = tooltipItem.raw;
                            const porcentaje = ((valor / datosGrafico.cantidadInfantes) * 100).toFixed(1);
                            return `Asistencias: ${valor} (${porcentaje}%)`;
                        }
                    }
                }
            },
            layout: { padding: { left: 10, right: 10, top: 20, bottom: 10 } }
        }
    });
});

