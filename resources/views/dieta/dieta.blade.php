<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <head>


    </head>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <style>
            #alimentosSeleccionados {
                display: flex;
                flex-wrap: wrap;
                /* Allow items to wrap to the next line */
                padding: 0;
                list-style: none;
                margin: 0;
                gap: 10px;
                /* Space between items */
                justify-content: space-between;
                /* Distributes items evenly in a row */
            }

            #alimentosSeleccionados li {
                flex: 0 0 calc(25% - 10px);
                /* Each item takes 25% of the width minus the gap */
                margin: 5px 0;
                /* Vertical margin for rows */
                box-sizing: border-box;
                /* Include padding and border in width calculation */
                text-align: center;
                /* Center the content inside each item */
                padding: 10px;
                border: 1px solid #ccc;
                /* Optional: Add border for better visual separation */
                border-radius: 5px;
                background-color: #f9f9f9;
                /* Optional: Background color */
            }

            #alimentosSeleccionados img {
                width: 80px;
                /* Adjust image size */
                height: 80px;
                object-fit: cover;
                /* Ensure images fit nicely */
            }
        </style>
        <div class="container-fluid py-4">
            <div class="col-12">
                <div class="card my-4">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    <div class="pd-20 card-box mb-30">
                        <div class="clearfix mb-20">
                            <div class="pull-left">
                                <h4 class="text-blue h4">Registrar Dieta</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <form method="POST" action="registrar-dieta" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="nombreDieta">Nombre Dieta</label>
                                        <select id="nombreDieta" name="nombreDieta" class="form-control select2">
                                            <option value="">Seleccione una Dieta</option>
                                            @foreach ($dietas as $dieta)
                                            <option value="{{ $dieta->nombre }}">{{ $dieta->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                            $('#nombreDieta').select2({
                                                tags: true, // Habilitar escritura y creación de nuevos elementos
                                                placeholder: 'Seleccione o escriba una Dieta',
                                                allowClear: true,
                                                createTag: function(params) {
                                                    let term = $.trim(params.term);
                                                    if (term === '') {
                                                        return null;
                                                    }
                                                    return {
                                                        id: term,
                                                        text: term,
                                                        newOption: true // Marca la opción como nueva
                                                    };
                                                },
                                                templateResult: function(data) {
                                                    if (data.newOption) {
                                                        return $('<span>Agregar: <strong>' + data.text + '</strong></span>');
                                                    }
                                                    return data.text;
                                                }
                                            });
                                        });
                                    </script>
                                    <!-- Selección de Alimentos -->
                                    <div class="form-group">
                                        <label>Seleccionar Alimento</label>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#alimentosModal">
                                            Seleccionar Alimento
                                        </button>
                                    </div>
                                    <div id="alimentosSeleccionados" class="mt-4">
                                        <h5>Alimentos Seleccionados:</h5>
                                        <!-- Campo oculto para almacenar los IDs de los alimentos seleccionados -->
                                        <input type="hidden" id="alimentosSeleccionadosInput" name="alimentosSeleccionados" multiple>

                                        <ul id="listaAlimentosSeleccionados" class="list-group">
                                            <!-- Los alimentos seleccionados se mostrarán aquí -->
                                        </ul>
                                    </div>
                                    <br>
                                    <!-- Modal -->
                                    <div class="modal fade" id="alimentosModal" tabindex="-1" role="dialog" aria-labelledby="alimentosModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content bg-light-gray">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="alimentosModalLabel">Seleccionar Alimento</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="filtroTipoAlimento">Filtrar por Tipo de Alimento:</label>
                                                        <select id="filtroTipoAlimento" class="form-control">
                                                            <option value="">Todos</option>
                                                            <!-- Opciones dinámicas según tus tipos de alimentos -->
                                                            @foreach($tiposDeAlimentos as $tipo)
                                                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div id="listaAlimentos" class="row">
                                                        @foreach($alimentos as $alimento)
                                                        <div class="col-md-4 alimento-item" data-tipo="{{ $alimento->id_tipoAlimento }}">
                                                            <div class="card mb-4">
                                                                <img src="{{ $alimento->nombreImagen }}" class="card-img-top" alt="Imagen del alimento">
                                                                <div class="card-body">
                                                                    <h5 class="card-title">{{ $alimento->nombre }}</h5>
                                                                    <button type="button" class="btn btn-success"
                                                                        onclick="seleccionarAlimento(
                                                                            {{ $alimento->id }}, 
                                                                            '{{ $alimento->nombre }}', 
                                                                            '{{ !empty($alimento->nombreImagen) ? asset($alimento->nombreImagen) : asset('path/to/default-image.jpg') }}'
                                                                        )">
                                                                        Seleccionar
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        // Filtrar alimentos por tipo
                                        filtroTipoAlimento.addEventListener('change', function() {
                                            const tipoSeleccionado = filtroTipoAlimento.value;
                                            document.querySelectorAll('.alimento-item').forEach(item => {
                                                if (!tipoSeleccionado || item.getAttribute('data-tipo') === tipoSeleccionado) {
                                                    item.style.display = '';
                                                } else {
                                                    item.style.display = 'none';
                                                }
                                            });
                                        });

                                        // Seleccionar un alimento
                                        window.seleccionarAlimento = function(id, nombre, imagenUrl) {
                                            // Generar un identificador único basado en el tiempo o un contador
                                            const uniqueId = `${id}_${Date.now()}`;

                                            // Crear el contenedor para el alimento seleccionado
                                            const li = document.createElement('li');
                                            li.className = 'list-group-item';
                                            li.dataset.id = uniqueId;

                                            // Crear los select dinámicamente con IDs únicos
                                            // Crear los elementos internos dinámicamente con IDs únicos
                                            li.innerHTML = `
    <div class="d-flex align-items-center mb-3">
        <img src="${imagenUrl}" alt="Imagen del alimento" class="img-thumbnail mr-3" style="width: 100px; height: 75px; object-fit: cover;">
        <div class="ml-3"> <!-- Contenedor para el texto del alimento -->
            <strong>${nombre}</strong>
        </div>
    </div>
    <!-- Contenedor separado para los selects -->
    <div class="form-section">
        <select class="form-control form-control-sm mb-2" id="periodoSelect_${uniqueId}" name="periodos[]">
            <option value="">Seleccione un Periodo</option> 
        </select> 
        <select class="form-control form-control-sm mb-2" id="diaSelect_${uniqueId}" disabled name="dias[]">
            <option value="">Seleccione un Día</option> 
        </select> 
        <select class="form-control form-control-sm mb-2" id="horaSelect_${uniqueId}" disabled name="horas[]">
            <option value="">Seleccione una Hora</option> 
        </select> 
    </div>
    <button type="button" class="btn btn-danger btn-sm mt-2" data-id="${uniqueId}">Eliminar</button>
`;

                                            // Aplicar estilos globales con CSS
                                            const style = document.createElement('style');
                                            style.textContent = `
    .list-group-item {
        margin-bottom: 15px;
        padding: 15px;
    }
    .form-section {
        margin-top: 10px;
        display: flex;
        flex-direction: column;
    }
    .d-flex.align-items-center {
        display: flex;
        align-items: center;
    }
    .img-thumbnail {
        flex-shrink: 0;
    }
    .form-control {
        width: 100%;  /* Garantiza que los selects ocupen todo el ancho disponible */
    }
    
`;
                                            document.head.appendChild(style);

                                            // Añadir el alimento a la lista
                                            listaAlimentosSeleccionados.appendChild(li);

                                            // Cargar los periodos
                                            cargarPeriodos(uniqueId);

                                            // Actualizar el input oculto con los IDs seleccionados
                                            actualizarAlimentosSeleccionados();

                                            // Cerrar el modal
                                            $('#alimentosModal').modal('hide');
                                        };

                                        // Función para cargar los periodos
                                        function cargarPeriodos(uniqueId) {
                                            fetch('/periodos')
                                                .then(response => response.json())
                                                .then(data => {
                                                    const periodoSelect = document.getElementById(`periodoSelect_${uniqueId}`);
                                                    data.forEach(periodo => {
                                                        const option = document.createElement('option');
                                                        option.value = periodo.id;
                                                        option.textContent = periodo.nombre;
                                                        periodoSelect.appendChild(option);

                                                    });

                                                    // Escuchar cambios en el select de periodo para cargar los días
                                                    periodoSelect.addEventListener('change', function() {
                                                        cargarDias(uniqueId, periodoSelect.value);
                                                    });
                                                });
                                        }
                                        // Función para cargar los días según el periodo
                                        function cargarDias(id, periodoId) {
                                            const diaSelect = document.getElementById(`diaSelect_${id}`);
                                            const horaSelect = document.getElementById(`horaSelect_${id}`);

                                            // Limpiar los días y las horas
                                            diaSelect.innerHTML = '<option name="dias[]  value="">Seleccione un Día</option>';
                                            horaSelect.innerHTML = '<option name="horas[]  value="">Seleccione una Hora</option>';
                                            horaSelect.disabled = true;

                                            if (periodoId) {
                                                fetch(`/dias/${periodoId}`)
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        data.forEach(dia => {
                                                            const option = document.createElement('option');
                                                            option.value = dia.id;
                                                            option.textContent = dia.nombre;
                                                            diaSelect.appendChild(option);
                                                        });
                                                        diaSelect.disabled = false;

                                                        // Escuchar cambios en el select de día para cargar las horas
                                                        diaSelect.addEventListener('change', function() {
                                                            cargarHoras(id, diaSelect.value);
                                                        });
                                                    });
                                            } else {
                                                diaSelect.disabled = true;
                                            }
                                        }

                                        // Función para cargar las horas según el día
                                        function cargarHoras(id, diaId) {
                                            const horaSelect = document.getElementById(`horaSelect_${id}`);

                                            // Limpiar las horas
                                            horaSelect.innerHTML = '<option name="horas[] value="">Seleccione una Hora</option>';

                                            if (diaId) {
                                                fetch(`/horas/${diaId}`)
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        data.forEach(hora => {
                                                            const option = document.createElement('option');
                                                            option.value = hora.id;
                                                            option.textContent = hora.hora;
                                                            horaSelect.appendChild(option);
                                                        });
                                                        horaSelect.disabled = false;
                                                    });
                                            } else {
                                                horaSelect.disabled = true;
                                            }
                                        }

                                        // Delegación de eventos para eliminar un alimento
                                        document.getElementById('listaAlimentosSeleccionados').addEventListener('click', function(event) {
                                            // Verificar si el elemento clickeado es un botón de eliminar
                                            if (event.target && event.target.matches('button.btn-danger')) {
                                                const li = event.target.closest('li');
                                                if (li) {
                                                    // Eliminar el alimento de la lista
                                                    li.remove();
                                                    // Actualizar los IDs de los alimentos seleccionados
                                                    actualizarAlimentosSeleccionados();
                                                    actualizarPeriodosSeleccionados();
                                                }
                                            }
                                        });

                                        // Actualizar el input oculto con los IDs seleccionados
                                        function actualizarAlimentosSeleccionados() {
                                            const ids = Array.from(listaAlimentosSeleccionados.children).map(li => li.dataset.id);
                                            alimentosSeleccionadosInput.value = ids.join(',');
                                        }

                                        function obtenerPeriodosSeleccionados() {
                                            const periodosSeleccionados = [];
                                            document.querySelectorAll('[id^="periodoSelect_"]').forEach(select => {
                                                if (select.value) {
                                                    periodosSeleccionados.push(select.value);
                                                }
                                            });
                                            return periodosSeleccionados;
                                        }

                                        // Función para actualizar periodos seleccionados
                                        function actualizarPeriodosSeleccionados() {
                                            const ids = Array.from(listaPeriodosSeleccionados.children).map(li => li.dataset.id);
                                            periodosSeleccionadosInput.value = ids.join(',');
                                        }
                                    </script>
                            </div>
                            <div class="col-md-4 col-sm-12 text-center">
                                <div class="form-group">
                                    <label for="descripcionDieta">Descripcion</label>
                                    <select id="descripcionDieta" name="descripcionDieta" class="form-control select2" required>
                                        <option value="">Seleccione una Dieta</option>
                                        @foreach ($dietas as $dieta)
                                        <option value="{{ $dieta->descripcion }}">{{ $dieta->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('#descripcionDieta').select2({
                                            tags: true, // Habilitar escritura y creación de nuevos elementos
                                            placeholder: 'Seleccione o escriba una Descrcipcion',
                                            allowClear: true,
                                            createTag: function(params) {
                                                let term = $.trim(params.term);
                                                if (term === '') {
                                                    return null;
                                                }
                                                return {
                                                    id: term,
                                                    text: term,
                                                    newOption: true // Marca la opción como nueva
                                                };
                                            },
                                            templateResult: function(data) {
                                                if (data.newOption) {
                                                    return $('<span>Agregar: <strong>' + data.text + '</strong></span>');
                                                }
                                                return data.text;
                                            }
                                        });
                                    });
                                </script>

                            </div>

                            <div class="col-md-12 mt-4 text-center">
                                <button type="submit" class="btn btn-success">Registrar Dieta</button>
                            </div>
                            </form>
                        </div>
                    </div>


                    <div class="pd-20 card-box mb-30">
                        <div class="clearfix mb-20">
                            <div class="pull-left">
                                <h4 class="text-blue h4">Alimentos</h4>
                                <table class="table hover multiple-select-row data-table-export nowrap">
                                    <thead>
                                        <tr>
                                            <th class="table-plus datatable-nosort">Dieta Nombre</th>
                                            <th class="table-plus datatable-nosort">Dieta Descripcion</th>
                                            <th>Alimento</th>
                                            <th>Periodo</th>
                                            <th>Dia</th>
                                            <th>Hora</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dietas as $dieta)
                                        @foreach ($dieta->detalleDietas2 as $detalle)
                                        <tr>
                                            <td>{{ $dieta->nombre }}</td>
                                            <td>{{ $dieta->descripcion }}</td>
                                            <td>{{ $detalle->alimento->nombre ?? 'No disponible' }}</td>
                                            <td>{{ $detalle->periodo->nombre ?? 'No disponible' }}</td>
                                            <td>{{ $detalle->dia->nombre ?? 'No disponible' }}</td>
                                            <td>{{ $detalle->horario->hora ?? 'No disponible' }}</td>
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