@vite(['resources/css/calendario.css'])
<div class="asistencia-calendario" x-data="{ diaSeleccionado: null, asistencias: [] }">
    <!-- Selector de Mes -->
    <form id="seleccionMes" class="asistencia-selector">
        <select name="mes" id="mes" class="asistencia-select" onchange="this.form.submit()">
            @foreach (range(1, 12) as $i)
                @php
                    $fechaMes = now()->month($i);
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
        $fecha = now()->parse($mes)->day($dia)->format('Y-m-d');
        $asistenciasDia = $asistenciasPorDia[$fecha] ?? collect([]);
        $estadoAsistencia = $asistenciasDia->sortByDesc('created_at')->first()->Estado ?? null;

        $claseEstado = match ($estadoAsistencia) {
            'Presente' => 'asistencia-presente',
            'Ausente Justificado' => 'asistencia-justificado',
            'Ausente Injustificado' => 'asistencia-injustificado',
            default => ''
        };
    @endphp

    <button class="asistencia-dia {{ $claseEstado }}"
        @if ($estadoAsistencia)
            @click="diaSeleccionado = '{{ $fecha }}'; 
            asistencias = {{ $asistenciasDia->values()->toJson() }}"
            data-bs-toggle="modal" data-bs-target="#modalAsistencia"
        @else
            onclick="window.location.href='{{ route('asistencia.agregar', ['infante_id' => $infante->id, 'fecha' => urlencode($fecha)]) }}'"
        @endif>
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
                        Asistencia de {{ explode(' ', trim($infante->Nombre))[0] }} {{ explode(' ', trim($infante->Apellido))[0] }}
                    </h5>
                                       
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body asistencia-modal-body">
                    <template x-for="asistencia in asistencias">
                        <div class="asistencia-detalle">
                            <p><strong>Fecha:</strong> <span x-text="new Date(diaSeleccionado).toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' })"></span>
                            <p><strong>Responsable:</strong> <span x-text="asistencia.usuario.Nombre"></span> <span
                                    x-text="asistencia.usuario.Apellido"></span></p>
                            <p><strong>Estado:</strong> <span x-text="asistencia.Estado"></span></p>
                            <p><strong>Horario:</strong> <span
                                    x-text="asistencia.Hora_Ingreso ?? 'No registrada'"></span> - <span x-text="asistencia.Hora_Salida ?? 'No registrada'"></span></p>
                            <p><strong>Observación:</strong> <span
                                    x-text="asistencia.Observacion ?? 'Sin observaciones'"></span></p>
                        </div>
                    </template>
                </div>
                <div class="modal-footer">
                    @if (auth()->user()->Categoria === 'Coordinador')
                        <div class="footer-buttons">
                            <template x-for="asistencia in asistencias" :key="asistencia.id">
                                <a :href="'{{ route('asistencia.editar', '') }}/' + asistencia.id" class="btn btn-modificar">
                                    <i class="fa-solid fa-pencil"></i> Modificar
                                </a>
                            </template>
                
                            <template x-for="asistencia in asistencias" :key="asistencia.id">
                                <form :action="'{{ route('asistencia.eliminar', '') }}' + '/' + asistencia.id" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-eliminar">
                                        <i class="fa-solid fa-trash-can"></i> Eliminar
                                    </button>
                                </form>
                            </template>
                        </div>
                    @endif
                </div>
                
            </div>
        </div>
    </div>
</div>
