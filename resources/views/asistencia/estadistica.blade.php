@vite(['resources/css/estadistica.css'])
@vite(['resources/js/grafico-barra.js'])

<div class="asistencias-chart-container" x-data="{
    mesSeleccionado: new URLSearchParams(window.location.search).get('mes') || {{ now()->month }}
}">
    <div class="asistencias-selector-container">
        <span>Asistencia del mes</span>
        <select id="mesSelector" x-model="mesSeleccionado" @change="window.location.href = `?mes=${mesSeleccionado}`">
            @foreach (range(1, 12) as $mes)
                <option value="{{ $mes }}" :selected="mesSeleccionado == {{ $mes }}">
                    {{ \Carbon\Carbon::createFromFormat('!m', $mes)->locale('es')->translatedFormat('F') }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="asistencias-chart-wrapper">
        <canvas id="asistenciasChart" data-grafico-datos='@json($graficoDatos)'></canvas>
    </div>

    <!-- Leyenda personalizada -->
    <div class="asistencias-legend">
        <span class="legend-box" style="background-color: #FF4D4D;"></span> 0-30% (Deficiente)
        <span class="legend-box" style="background-color: #FFA500;"></span> 30-50% (Insuficiente)
        <span class="legend-box" style="background-color: #FFD700;"></span> 50-70% (Moderada)
        <span class="legend-box" style="background-color: #90EE90;"></span> 70-90% (Buena)
        <span class="legend-box" style="background-color: #008000;"></span> 90-100% (Excelente)
    </div>
    
</div>