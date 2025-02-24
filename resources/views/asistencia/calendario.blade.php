<div class="asistencia-calendario" x-data="{ diaSeleccionado: null, asistencias: [] }">
    <!-- Selector de Mes -->
    <form id="seleccionMes" class="asistencia-selector">
        <select name="mes" id="mes" class="asistencia-select" onchange="this.form.submit()">
            @foreach (range(1, 12) as $i)
                @php
                    $fechaMes = now()->year(2025)->month($i);
                    $valor = $fechaMes->format('Y-m');
                @endphp
                <option value="{{ $valor }}"
                    {{ $valor === request('mes', now()->format('Y-m')) ? 'selected' : '' }}>
                    {{ $fechaMes->translatedFormat('F Y') }}
                </option>
            @endforeach
        </select>
    </form>

    <!-- Calendario -->
    <div class="asistencia-grid">
        @foreach (['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa', 'Do'] as $dia)
            <div class="asistencia-dia-header">{{ $dia }}</div>
        @endforeach

        @php
            $primerDiaSemana = now()->parse($mes)->startOfMonth()->dayOfWeekIso;
        @endphp

        @for ($i = 1; $i < $primerDiaSemana; $i++)
            <div class="asistencia-dia asistencia-dia-vacio"></div>
        @endfor

        @foreach (range(1, now()->parse($mes)->daysInMonth) as $dia)
            @php
                $fecha = now()->parse($mes)->day($dia);
                $hayAsistencia = isset($asistenciasPorDia[$fecha->format('Y-m-d')]);
            @endphp
            <button class="asistencia-dia {{ $hayAsistencia ? 'asistencia-dia-activo' : '' }}"
                @click="diaSeleccionado = '{{ $fecha->format('Y-m-d') }}'; asistencias = {{ json_encode($asistenciasPorDia[$fecha->format('Y-m-d')] ?? []) }}"
                data-bs-toggle="modal" data-bs-target="#modalAsistencia">
                {{ $dia }}
            </button>
        @endforeach
    </div>

    
    <!-- Modal de Asistencia -->
    <div class="modal fade asistencia-modal" id="modalAsistencia" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header asistencia-modal-header">
                    <h5 class="modal-title">
                        Asistencias del día <span x-text="diaSeleccionado"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body asistencia-modal-body">
                    <template x-if="asistencias.length === 0">
                        <p class="text-muted">No hay asistencias registradas para este día.</p>
                    </template>

                    <template x-for="asistencia in asistencias">
                        <div class="asistencia-detalle">
                            <strong>Responsable:</strong> 
                            <span x-text="asistencia.usuario?.Nombre ?? 'Desconocido'"></span> 
                            <span x-text="asistencia.usuario?.Apellido ?? ''"></span><br>
                            
                            <strong>Horario:</strong> 
                            <span x-text="asistencia.Hora_Ingreso"></span> - 
                            <span x-text="asistencia.Hora_Salida"></span>
                        </div>
                    </template>
                    
                </div>

                <div class="modal-footer">
                    <!-- Botón Registrar Asistencia (para Maestro y Coordinador, si NO hay asistencia) -->
                    @if (in_array(auth()->user()->Categoria, ['Maestro', 'Coordinador']))
                        <template x-if="asistencias.length === 0">
                            <button class="btn btn-success">Registrar Asistencia</button>
                        </template>
                    @endif

                    <!-- Botón Modificar (solo Coordinador, si hay asistencia) -->
                    @if (auth()->user()->Categoria === 'Coordinador')
                        <template x-if="asistencias.length > 0">
                            <button class="btn btn-primary">Modificar</button>
                        </template>
                    @endif

                    <!-- Botón Eliminar (solo Coordinador, si hay asistencia) -->
                    @if (auth()->user()->Categoria === 'Coordinador')
                        <template x-if="asistencias.length > 0">
                            <button class="btn btn-danger">Eliminar</button>
                        </template>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
