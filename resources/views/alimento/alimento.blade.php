<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <head>
        <style>
            .imagenes-container {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin-top: 10px;
            }

            .imagenes-container img {
                width: 100px;
                height: 100px;
                object-fit: cover;
                margin: 5px;
                border: 1px solid #ccc;
                /* Opcional: bordes para mejor visualización */
            }
        </style>
        <meta name="csrf-token" content="{{ csrf_token() }}">


    </head>
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


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
                                <h4 class="text-blue h4">Registrar Alimento</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <form method="POST" action="registrar-alimento" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="nombreAlimento">Tipo de Alimento</label>
                                        <select id="nombreAlimento" name="nombreAlimento" class="form-control select2">
                                            <option value="">Seleccione un tipo de alimento</option>
                                            @foreach ($tiposAlimentos as $tipo)
                                            <option value="{{ $tipo->nombre }}">{{ $tipo->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <script>
                                        $(document).ready(function() {
                                            $('#nombreAlimento').select2({
                                                tags: true, // Habilitar escritura y creación de nuevos elementos
                                                placeholder: 'Seleccione o escriba un tipo de alimento',
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


                                    <div>
                                        <div id="contenedorAlimentos">
                                            <!-- Aquí se añadirán dinámicamente los alimentos -->
                                        </div>
                                        <br>

                                        <button id="btnAgregarAlimento" type="button" class="btn btn-success btn-agregar">Agregar otro
                                            Alimento</button>
                                        <button id="btnEliminarAlimento" type="button" class="btn btn-danger" style="display: none;">Eliminar último
                                            Alimento</button>
                                    </div>
                                    <!-- Scripts -->
                                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const contenedorAlimentos = document.getElementById('contenedorAlimentos');
                                            const btnAgregarAlimento = document.getElementById('btnAgregarAlimento');
                                            const btnEliminarAlimento = document.getElementById('btnEliminarAlimento');
                                            let contadorAlimentos = 0;

                                            // Agregar el primer denunciado al cargar la página
                                            agregarAlimento();

                                            // Event listener para el botón de agregar denunciado
                                            btnAgregarAlimento.addEventListener('click', agregarAlimento);

                                            // Event listener para el botón de eliminar denunciado
                                            btnEliminarAlimento.addEventListener('click', eliminarUltimoAlimento);

                                            function agregarAlimento() {
                                                contadorAlimentos++;

                                                // Crear div para el nuevo denunciado
                                                const divAlimento = document.createElement('div');
                                                divAlimento.id = `alimento${contadorAlimentos}`;
                                                divAlimento.classList.add('campo');

                                                // Contenido del div para el nuevo denunciado
                                                divAlimento.innerHTML = `
                
                              <fieldset style="display: flex; flex-wrap: wrap; gap: 10px;">
                                    <legend style="font-weight: bold;">Alimento ${contadorAlimentos}</legend>
                                    <div class="campo" style="flex: 1 1 calc(33.333% - 10px); max-width: calc(33.333% - 10px);">
                                        <label for="nombreAlimento${contadorAlimentos}">Nombre:</label>
                                        <input type="text" style="border: 1px solid black;" id="nombreAlimento${contadorAlimentos}" name="alimentos[${contadorAlimentos}][nombre]" class="form-control" required>
                                    </div>
                                    <div class="campo" style="flex: 1 1 calc(33.333% - 10px); max-width: calc(33.333% - 10px);">
                                        <label for="caloriaAlimento${contadorAlimentos}">Caloria:</label>
                                        <input type="text" style="border: 1px solid black;" id="caloriaAlimento${contadorAlimentos}" name="alimentos[${contadorAlimentos}][caloria]" class="form-control">
                                    </div>
                                    <div class="campo" style="flex: 1 1 calc(33.333% - 10px); max-width: calc(33.333% - 10px);">
                                        <label for="carbohidratoAlimento${contadorAlimentos}">Carbohidrato:</label>
                                        <input type="text" style="border: 1px solid black;" id="carbohidratoAlimento${contadorAlimentos}" name="alimentos[${contadorAlimentos}][carbohidrato]" class="form-control">
                                    </div>
                                    <div class="campo" style="flex: 1 1 calc(33.333% - 10px); max-width: calc(33.333% - 10px);">
                                        <label for="proteinaAlimento${contadorAlimentos}">Proteina:</label>
                                        <input type="text" style="border: 1px solid black;" id="proteinaAlimento${contadorAlimentos}" name="alimentos[${contadorAlimentos}][proteina]" class="form-control">
                                    </div>
                                    <div class="campo" style="flex: 1 1 calc(33.333% - 10px); max-width: calc(33.333% - 10px);">
                                        <label for="grasaAlimento${contadorAlimentos}">Grasa:</label>
                                        <input type="text" style="border: 1px solid black;" id="grasaAlimento${contadorAlimentos}" name="alimentos[${contadorAlimentos}][grasa]" class="form-control">
                                    </div>
                                    <br>
                                    <!-- Subir Imágenes de alimentos -->
                                    <div class="campo" style="flex: 1 1 calc(33.333% - 10px); max-width: calc(33.333% - 10px);">
                                        <label for="alimentoImagenes${contadorAlimentos}">Subir imagen</label>
                                        <br>
                                        <!-- Input de archivo -->
                                        <input 
                                            type="file" 
                                            id="alimentoImagenes${contadorAlimentos}" 
                                            name="alimentos[${contadorAlimentos}][imagen]" 
                                            multiple 
                                            class="form-control" 
                                            onchange="previsualizarImagenes(this, 'preview_${contadorAlimentos}')"
                                        >
                                        <!-- Contenedor de previsualización -->
                                        <div id="preview_${contadorAlimentos}" style="width: 100px; height: 100px; border: 1px solid #ccc; margin-left: 10px; display: flex; justify-content: center; align-items: center; overflow: hidden;">
                                            <span style="color: #888; font-size: 12px;">No imagen</span>
                                        </div>
                                    </div>
                                </fieldset>
                            `;

                                                // Añadir nuevo div de denunciado al contenedor
                                                contenedorAlimentos.appendChild(divAlimento);
                                                // Verifica los valores de los campos generados
                                                console.log(`Se agregó alimento ${contadorAlimentos}`);
                                                console.log(contenedorAlimentos); // Muestra el contenedor completo en la consola

                                                // Mostrar el botón de eliminar si hay más de un denunciado
                                                if (contadorAlimentos > 1) {
                                                    btnEliminarAlimento.style.display = 'block';
                                                }
                                            }


                                            function eliminarUltimoAlimento() {
                                                const ultimoAlimento = contenedorAlimentos.lastElementChild;
                                                if (ultimoAlimento && contadorAlimentos > 1) {
                                                    contenedorAlimentos.removeChild(ultimoAlimento);
                                                    contadorAlimentos--;

                                                    // Ocultar el botón de eliminar si queda solo un denunciado
                                                    if (contadorAlimentos === 1) {
                                                        btnEliminarAlimento.style.display = 'none';
                                                    }
                                                }
                                            }



                                        });
                                        //imagenes    
                                        function previsualizarImagenes(input, previewContainerId) {
                                            const contenedor = document.getElementById(previewContainerId);
                                            contenedor.innerHTML = ''; // Limpia el contenido anterior

                                            if (input.files && input.files[0]) { // Solo toma la primera imagen
                                                console.log('Archivo seleccionado:', input.files[0]); // Verifica si se selecciona el archivo
                                                const reader = new FileReader();

                                                reader.onload = function(e) {
                                                    const img = document.createElement('img');
                                                    img.src = e.target.result;
                                                    img.style.width = '100%'; // Ajusta a tamaño del contenedor
                                                    img.style.height = '100%';
                                                    img.style.objectFit = 'cover';
                                                    contenedor.appendChild(img);
                                                };

                                                reader.readAsDataURL(input.files[0]); // Lee el archivo seleccionado
                                            } else {
                                                console.log('No se seleccionó ningún archivo.');
                                                contenedor.innerHTML = '<span style="color: #888; font-size: 12px;">No imagen</span>';
                                            }
                                        }

                                        function openModalEditAlimento(id) {
                                            fetch(`/alimento/edit/${id}`)
                                                .then(response => response.json())
                                                .then(data => {
                                                    if (!data) {
                                                        throw new Error('No se recibieron datos del servidor');
                                                    }

                                                    // Asignar los valores a los campos del formulario
                                                    document.getElementById('nombre_edit_alimento').value = data.nombre;
                                                    document.getElementById('calorias_edit_alimento').value = data.caloria;
                                                    document.getElementById('carbohidrato_edit_alimento').value = data.carbohidrato;
                                                    document.getElementById('proteina_edit_alimento').value = data.proteina;
                                                    document.getElementById('grasa_edit_alimento').value = data.grasa;
                                                    document.getElementById('editFormCuarto').action = `/alimento-update/${id}`;

                                                    // Cargar la imagen existente en el modal
                                                    var imagenesEditContainer = document.getElementById('imagenes_edit_container');
                                                    imagenesEditContainer.innerHTML = ''; // Limpia imágenes previas

                                                    if (data.nombreImagen) { // Verificar si hay una imagen
                                                        var imageContainer = document.createElement('div');
                                                        imageContainer.classList.add('imagen-container', 'm-2');

                                                        var image = document.createElement('img');
                                                        image.src = `${window.location.origin}/${data.nombreImagen}`;
                                                        image.classList.add('img-thumbnail');
                                                        image.style.maxWidth = '100px';
                                                        image.style.maxHeight = '100px';

                                                        var deleteButton = document.createElement('button');
                                                        deleteButton.textContent = 'Eliminar';
                                                        deleteButton.classList.add('btn', 'btn-danger', 'btn-sm', 'ms-2');
                                                        deleteButton.onclick = function(event) {
                                                            event.preventDefault();
                                                            deleteImage(data.id, imageContainer); // Pasamos el ID del alimento
                                                        };

                                                        imageContainer.appendChild(image);
                                                        imageContainer.appendChild(deleteButton);
                                                        imagenesEditContainer.appendChild(imageContainer);
                                                    }

                                                    // Mostrar el modal
                                                    var myModal = new bootstrap.Modal(document.getElementById('myModalEditCuarto'));
                                                    myModal.show();
                                                })
                                                .catch(error => {
                                                    console.error('Error al abrir el modal:', error);
                                                });
                                        }

                                        function deleteImage(alimentoId, imageContainer) {
                                            if (confirm('¿Estás seguro de que quieres eliminar esta imagen?')) {
                                                fetch(`/alimento/delete-image/${alimentoId}`, {
                                                        method: 'DELETE',
                                                        headers: {
                                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF token for Laravel
                                                        }
                                                    })
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        if (data.success) {
                                                            // Remove the image container from the DOM
                                                            imageContainer.remove();
                                                            alert(data.message);
                                                        } else {
                                                            alert('Error al eliminar la imagen: ' + data.message);
                                                        }
                                                    })
                                                    .catch(error => {
                                                        console.error('Error:', error);
                                                        alert('Hubo un error al eliminar la imagen.');
                                                    });
                                            }
                                        }
                                    </script>
                            </div>

                            <div class="col-md-12 mt-4 text-center">
                                <button type="submit" class="btn btn-success">Registrar Alimento</button>
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
                                            <th class="table-plus datatable-nosort">Tipo Alimento</th>
                                            <th>Alimentos</th>
                                            <th>Accion</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($alimentos as $alimento)
                                        <tr>
                                            <td class="table-plus">{{$alimento->tipoAlimento->nombre ?? "N/A"}}</td>
                                            <td class="table-plus">{{$alimento->nombre ?? "N/A"}}</td>
                                            <td class="align-middle text-center">
                                                <button class="btn btn-success btn-sm" onclick="openModalEditAlimento({{ $alimento->id }})">
                                                    <i class="icon-copy fa fa-edit" aria-hidden="true"></i>
                                                </button>
                                            </td>

                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No hay alimentos registrados.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Modal para editar cuarto -->
                    <div class="modal fade" id="myModalEditCuarto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content bg-light-gray">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Editar Alimento</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editFormCuarto" action="" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <!-- Campos del formulario -->
                                        <div class="form-group">
                                            <label for="nombre_edit_alimento">Nombre</label>
                                            <input type="text" id="nombre_edit_alimento" name="nombre" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="calorias_edit_alimento">Calorias:</label>
                                            <input type="text" id="calorias_edit_alimento" name="caloria" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="carbohidrato_edit_alimento">Carbohidratos:</label>
                                            <input type="text" id="carbohidrato_edit_alimento" name="carbohidrato" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="grasa_edit_alimento">Grasa:</label>
                                            <input type="text" id="grasa_edit_alimento" name="grasa" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="proteina_edit_alimento">Proteina:</label>
                                            <input type="text" id="proteina_edit_alimento" name="proteina" class="form-control" required>
                                        </div>
                                        
                                        <div id="imagenes_edit_container" class="d-flex flex-wrap">
                                            <!-- Imágenes existentes se cargarán aquí -->
                                        </div>
                                        <div class="form-group">
                                            <label for="nuevas_imagenes">Agregar nuevas imágenes</label>
                                            <input type="file" id="nuevas_imagenes" name="imagen" multiple class="form-control" onchange="previsualizarImagenes()">
                                        </div>
                                        <br>
                                        <button type="submit" class="btn btn-success">Guardar cambios</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
</x-layout>