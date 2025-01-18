@vite(['resources/css/estadistica.css'])
@vite(['resources/js/grafico.js'])

<div class="estadistica-sala">
    @if ($sala1)
        <div class="sala-contenedor">
            <!-- Titulo Sala 1 -->
            <div class="titulo-sala">
                <h3>{{ $sala1->Nombre }}</h3>
            </div>

            <!-- Gráficos de Sala 1 -->
            <div class="graficos">
                <div class="estadistica" 
                    data-id="chartSala1_1" 
                    data-porcentaje="{{ $sala1->porcentajeCapacidad }}"
                    data-colores="{{ $sala1->porcentajeCapacidad >= 100 ? '#FF6347,#FAD7A0' : '#77DD77,#FAD7A0' }}" 
                    data-icono="fa-crown">
                    <div class="grafico">
                        <canvas id="chartSala1_1" class="grafico"></canvas>
                        <div class="cantidad-adentro uno">
                            <i class="fa-solid fa-people-roof"></i>
                        </div>
                    </div>
                </div>
                <div class="estadistica" 
                    data-id="chartSala2_1" 
                    data-porcentaje="{{ $sala1->porcentajeIngresantes }}"
                    data-colores="#FFC107,#FF6F31" 
                    data-icono="fa-crown">
                    <div class="grafico">
                        <canvas id="chartSala2_1" class="grafico"></canvas>
                        <div class="cantidad-adentro">
                            <i class="fa-solid fa-user-check"></i>/<i class="fa-solid fa-user-plus"></i>
                        </div>
                    </div>
                </div>
                <div class="estadistica"
                    data-id="chartSala3_1" 
                    data-porcentaje="{{ $sala1->porcentajeHabilitados }}"
                    data-colores="#00BFA5,#4FC3F7" 
                    data-icono="fa-crown">
                    <div class="grafico">
                        <canvas id="chartSala3_1" class="grafico"></canvas>
                        <div class="cantidad-adentro">
                            <i class="fa-solid fa-lock"></i>/<i class="fa-solid fa-lock-open"></i>
                            </div>
                    </div>
                </div>
            </div>

            <!-- Listado de Porcentajes Sala 1 -->
            <div class="listado">
                <ul>
                    <li>
                        <i class="ico fa-solid fa-people-roof"></i>
                        <span class="titulo">Capacidad:</span>
                        <span class="detalle">{{ $sala1->habilitados }} de {{ $sala1->Capacidad }}</span>
                        <span class="porcentaje">{{ number_format($sala1->porcentajeCapacidad, 2) }}%</span>
                    </li>
                    <li>
                        <i class="ico fa-solid fa-user-plus"></i>
                        <span class="titulo">Ingresantes:</span>
                        <span class="detalle">{{ $sala1->ingresantes }} de {{ $sala1->cantidad }}</span>
                        <span class="porcentaje">{{ number_format($sala1->porcentajeIngresantes, 2) }}%</span>
                    </li>
                    <li>
                        <i class="ico fa-solid fa-user-check"></i>
                        <span class="titulo">Readmitidos:</span>
                        <span class="detalle">{{ $sala1->readmitidos }} de {{ $sala1->cantidad }}</span>
                        <span class="porcentaje">{{ number_format($sala1->porcentajeReadmitidos, 2) }}%</span>
                    </li>
                    <li>
                        <i class="ico fa-solid fa-lock-open"></i>
                        <span class="titulo">Habilitados:</span>
                        <span class="detalle">{{ $sala1->habilitados }} de {{ $sala1->cantidad }}</span>
                        <span class="porcentaje">{{ number_format($sala1->porcentajeHabilitados, 2) }}%</span>
                    </li>
                    <li>
                        <i class="ico fa-solid fa-lock"></i>
                        <span class="titulo">Inhabilitados:</span>
                        <span class="detalle">{{ $sala1->deshabilitados }} de {{ $sala1->cantidad }}</span>
                        <span class="porcentaje">{{ number_format($sala1->porcentajeDeshabilitados, 2) }}%</span>
                    </li>
                </ul>
            </div>

        </div>
    @endif

    @if ($sala2)
        <div class="sala-contenedor">
            <!-- Titulo Sala 2 -->
            <div class="titulo-sala">
                <h3>{{ $sala2->Nombre }}</h3>
            </div>

            <!-- Gráficos de Sala 2 -->
            <div class="graficos">
                <div class="estadistica" 
                    data-id="chartSala1_2" 
                    data-porcentaje="{{ $sala2->porcentajeCapacidad }}"
                    data-colores="{{ $sala2->porcentajeCapacidad >= 100 ? '#FF6347,#FAD7A0' : '#77DD77,#FAD7A0' }}" 
                    data-icono="fa-crown">
                    <div class="grafico">
                        <canvas id="chartSala1_2" class="grafico"></canvas>
                        <div class="cantidad-adentro uno">
                            <i class="fa-solid fa-people-roof"></i>
                        </div>
                    </div>
                </div>
                <div class="estadistica" 
                    data-id="chartSala2_2" 
                    data-porcentaje="{{ $sala2->porcentajeIngresantes }}"
                    data-colores="#FFC107,#FF6F31" 
                    data-icono="fa-crown">
                    <div class="grafico">
                        <canvas id="chartSala2_2" class="grafico"></canvas>
                        <div class="cantidad-adentro">
                            <i class="fa-solid fa-user-check"></i>/<i class="fa-solid fa-user-plus"></i>
                        </div>
                    </div>
                </div>
                <div class="estadistica" 
                    data-id="chartSala3_2" 
                    data-porcentaje="{{ $sala2->porcentajeHabilitados }}"
                    data-colores="#00BFA5,#4FC3F7" 
                    data-icono="fa-crown">
                    <div class="grafico">
                        <canvas id="chartSala3_2" class="grafico"></canvas>
                        <div class="cantidad-adentro">
                            <i class="fa-solid fa-lock"></i>/<i class="fa-solid fa-lock-open"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Listado de Porcentajes Sala 2 -->
            <div class="listado">
                <ul>
                    <li>
                        <i class="ico fa-solid fa-people-roof"></i>
                        <span class="titulo">Capacidad:</span>
                        <span class="detalle">{{ $sala2->habilitados }} de {{ $sala2->Capacidad }}</span>
                        <span class="porcentaje">{{ number_format($sala2->porcentajeCapacidad, 2) }}%</span>
                    </li>
                    <li>
                        <i class="ico fa-solid fa-user-plus"></i>
                        <span class="titulo">Ingresantes:</span>
                        <span class="detalle">{{ $sala2->ingresantes }} de {{ $sala2->cantidad }}</span>
                        <span class="porcentaje">{{ number_format($sala2->porcentajeIngresantes, 2) }}%</span>
                    </li>
                    <li>
                        <i class="ico fa-solid fa-user-check"></i>
                        <span class="titulo">Readmitidos:</span>
                        <span class="detalle">{{ $sala2->readmitidos }} de {{ $sala2->cantidad }}</span>
                        <span class="porcentaje">{{ number_format($sala2->porcentajeReadmitidos, 2) }}%</span>
                    </li>
                    <li>
                        <i class="ico fa-solid fa-lock-open"></i>
                        <span class="titulo">Habilitados:</span>
                        <span class="detalle">{{ $sala2->habilitados }} de {{ $sala2->cantidad }}</span>
                        <span class="porcentaje">{{ number_format($sala2->porcentajeHabilitados, 2) }}%</span>
                    </li>
                    <li>
                        <i class="ico fa-solid fa-lock"></i>
                        <span class="titulo">Inhabilitados:</span>
                        <span class="detalle">{{ $sala2->deshabilitados }} de {{ $sala2->cantidad }}</span>
                        <span class="porcentaje">{{ number_format($sala2->porcentajeDeshabilitados, 2) }}%</span>
                    </li>
                </ul>
            </div>

        </div>
    @endif

    @if ($sala3)
        <div class="sala-contenedor">
            <!-- Titulo Sala 3 -->
            <div class="titulo-sala">
                <h3>{{ $sala3->Nombre }}</h3>
            </div>

            <!-- Gráficos de Sala 3 -->
            <div class="graficos">
                <div class="estadistica" 
                    data-id="chartSala1_3" 
                    data-porcentaje="{{ $sala3->porcentajeCapacidad }}"
                    data-colores="{{ $sala3->porcentajeCapacidad >= 100 ? '#FF6347,#FAD7A0' : '#77DD77,#FAD7A0' }}" 
                    data-icono="fa-crown">
                    <div class="grafico">
                        <canvas id="chartSala1_3" class="grafico"></canvas>
                        <div class="cantidad-adentro uno">
                            <i class="fa-solid fa-people-roof"></i>
                        </div>
                    </div>
                </div>
                <div class="estadistica" 
                    data-id="chartSala2_3"
                    data-porcentaje="{{ $sala3->porcentajeIngresantes }}" 
                    data-colores="#FFC107,#FF6F31"
                    data-icono="fa-crown">
                    <div class="grafico">
                        <canvas id="chartSala2_3" class="grafico"></canvas>
                        <div class="cantidad-adentro">
                            <i class="fa-solid fa-user-check"></i>/<i class="fa-solid fa-user-plus"></i>
                        </div>
                    </div>
                </div>
                <div class="estadistica" 
                    data-id="chartSala3_3"
                    data-porcentaje="{{ $sala3->porcentajeHabilitados }}"
                    data-colores="#00BFA5,#4FC3F7"
                    data-icono="fa-crown">
                    <div class="grafico">
                        <canvas id="chartSala3_3" class="grafico"></canvas>
                        <div class="cantidad-adentro">
                            <i class="fa-solid fa-lock"></i>/<i class="fa-solid fa-lock-open"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Listado de Porcentajes Sala 3 -->
            <div class="listado">
                <ul>
                    <li>
                        <i class="ico fa-solid fa-people-roof"></i>
                        <span class="titulo">Capacidad:</span>
                        <span class="detalle">{{ $sala3->habilitados }} de {{ $sala3->Capacidad }}</span>
                        <span class="porcentaje">{{ number_format($sala3->porcentajeCapacidad, 2) }}%</span>
                    </li>
                    <li>
                        <i class="ico fa-solid fa-user-plus"></i>
                        <span class="titulo">Ingresantes:</span>
                        <span class="detalle">{{ $sala3->ingresantes }} de {{ $sala3->cantidad }}</span>
                        <span class="porcentaje">{{ number_format($sala3->porcentajeIngresantes, 2) }}%</span>
                    </li>
                    <li>
                        <i class="ico fa-solid fa-user-check"></i>
                        <span class="titulo">Readmitidos:</span>
                        <span class="detalle">{{ $sala3->readmitidos }} de {{ $sala3->cantidad }}</span>
                        <span class="porcentaje">{{ number_format($sala3->porcentajeReadmitidos, 2) }}%</span>
                    </li>
                    <li>
                        <i class="ico fa-solid fa-lock-open"></i>
                        <span class="titulo">Habilitados:</span>
                        <span class="detalle">{{ $sala3->habilitados }} de {{ $sala3->cantidad }}</span>
                        <span class="porcentaje">{{ number_format($sala3->porcentajeHabilitados, 2) }}%</span>
                    </li>
                    <li>
                        <i class="ico fa-solid fa-lock"></i>
                        <span class="titulo">Inhabilitados:</span>
                        <span class="detalle">{{ $sala3->deshabilitados }} de {{ $sala3->cantidad }}</span>
                        <span class="porcentaje">{{ number_format($sala3->porcentajeDeshabilitados, 2) }}%</span>
                    </li>
                </ul>
            </div>

        </div>
    @endif
</div>
