<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <head>
    </head>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="col-12">
                <div class="card my-4">
                    <div class="pd-20 card-box mb-30">
                        <div class="clearfix mb-20">
                            <div class="pull-left">
                                <h4 class="text-blue h4">Registrar Periodo</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <form method="post" action="{{route('registrar_periodo')}}">
                                    @csrf
                                    <div class="form-group">

                                        <label>Seleccionar Periodo</label>
                                        <input name="nombre_periodo" class="form-control datetimepicker-range" placeholder="Seleccionar rango" type="text">

                                    </div>
                                    <div class="form-group">
                                        <label>Nombre Periodo</label>
                                        <input name="nombre" class="form-control" placeholder="Nombre Periodo" type="text">
                                    </div>
                            </div>
                            <div class="col-md-4 col-sm-12 text-center">
                                <label>Seleccionar Días</label>
                                <select id="dias_disponibles" name="dias[]" class="custom-select2 form-control" multiple="multiple" style="width: 100%;">
                                    @foreach($diasS as $dia)
                                    <option value="{{ $dia->id }}">{{ $dia->nombre }}</option>
                                    @endforeach
                                </select><br>
                            </div>
                            <div class="col-md-4 col-sm-12 text-center">
                                <label>Seleccionar Horas</label>
                                <div id="horas-container">
                                    <input class="form-control time-picker" placeholder="Hora" type="text" id="hora-input">
                                </div>
                                <button type="button" class="btn btn-primary mt-2" onclick="agregarHora()">Agregar Hora</button>
                                <input type="hidden" name="horas" id="horas-seleccionadas">
                            </div>
                            <div class="col-md-12 mt-4 text-center">
                                <button type="submit" class="btn btn-success">Registrar Periodo</button>
                            </div>
                            </form>
                        </div>
                    </div>

                    <script>
                        const horasSeleccionadas = [];

                        function agregarHora() {
                            const horaInput = document.getElementById("hora-input");
                            const hora = horaInput.value;

                            if (hora) {
                                horasSeleccionadas.push(hora);
                                actualizarHorasSeleccionadas();

                                const horasContainer = document.getElementById("horas-container");
                                const horaLabel = document.createElement("span");
                                horaLabel.classList.add("badge", "badge-primary", "mr-2", "hora-badge");
                                horaLabel.innerText = hora;

                                // Botón de eliminación
                                const deleteButton = document.createElement("button");
                                deleteButton.classList.add("btn", "btn-sm", "btn-danger", "ml-2");
                                deleteButton.innerText = "X";
                                deleteButton.onclick = () => eliminarHora(hora, horaLabel);

                                horaLabel.appendChild(deleteButton);
                                horasContainer.appendChild(horaLabel);

                                horaInput.value = ''; // Limpia el campo después de agregar la hora
                            }
                        }

                        function eliminarHora(hora, horaLabel) {
                            // Elimina la hora del array
                            const index = horasSeleccionadas.indexOf(hora);
                            if (index > -1) {
                                horasSeleccionadas.splice(index, 1);
                                actualizarHorasSeleccionadas();
                            }

                            // Elimina el elemento visual
                            horaLabel.remove();
                        }

                        function actualizarHorasSeleccionadas() {
                            document.getElementById("horas-seleccionadas").value = horasSeleccionadas.join(',');
                        }
                    </script>
                    <div class="pd-20 card-box mb-30">
                        <div class="clearfix mb-20">
                            <div class="pull-left">
                                <h4 class="text-blue h4">Periodos</h4>
                                <table class="table hover multiple-select-row data-table-export nowrap">
                                    <thead>
                                        <tr>
                                            <th class="table-plus datatable-nosort">Periodo</th>
                                            <th>Dia</th>
                                            <th>Horas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($horarios as $periodoNombre => $dias)
                                        @php $mostrarNombrePeriodo = true; @endphp <!-- Variable de control para mostrar el nombre del período solo una vez -->

                                        @foreach ($dias as $diaNombre => $horas)
                                        <tr>
                                            <!-- Nombre del periodo solo en la primera fila de su grupo -->
                                            @if ($mostrarNombrePeriodo)
                                            <td rowspan="{{ count($dias) }}" class="table-plus">
                                                {{ $periodoNombre }}
                                            </td>
                                            @php $mostrarNombrePeriodo = false; @endphp
                                            @endif

                                            <!-- Nombre del día y horas -->
                                            <td>{{ $diaNombre }}</td>
                                            <td>{{ $horas->pluck('hora')->implode(', ') }}</td>
                                        </tr>
                                        @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
</x-layout>