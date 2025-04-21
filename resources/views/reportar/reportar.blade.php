<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Incluir librerías CSS y JS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <div class="container py-4">
            <div class="card shadow-lg">
                <!-- Encabezado -->
                <div class="card-header bg-primary text-white text-center py-3">
                <img src="{{ asset('src/images/correo.png') }}" alt="Logo" style="max-width: 40px; margin-right: 10px;">
                 CORREOS
                </div>

                <!-- Cuerpo del Formulario -->
                <div class="card-body">
                    <form action="{{ route('contactoStore') }}" method="POST">
                        @csrf

                        <!-- Nombre -->
                        <div class="mb-3">
                            <label for="nombre" class="form-label fw-bold small">Nombre</label>
                            <input type="text" id="nombre" name="nombre" 
                                class="form-control form-control-sm shadow-sm" 
                                placeholder="Ingrese su nombre">
                            @error('nombre')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Correo Remitente -->
                        <div class="mb-3">
                            <label for="correo_remitente" class="form-label fw-bold small">Correo Remitente</label>
                            <input type="email" id="correo_remitente" name="correo_remitente" 
                                class="form-control form-control-sm shadow-sm bg-light" 
                                value="{{ Auth::user()->email }}" readonly>
                            @error('correo_remitente')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Correo Destinatario -->
                        <div class="mb-3">
                            <label for="correo_destino_select" class="form-label fw-bold small">Correo Destinatario</label>
                            <select id="correo_destino_select" name="correo_destino[]" 
                                class="form-control form-control-sm shadow-sm" multiple="multiple">
                                @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->email }}">{{ $usuario->email }}</option>
                                @endforeach
                            </select>
                            <button type="button" id="addGerenciaButton" 
                                class="btn btn-outline-primary btn-sm mt-2 px-3 py-1" 
                                onclick="addGerencia()">Gerencia</button>
                            @error('correo_destino')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Asunto -->
                        <div class="mb-3">
                            <label for="asunto" class="form-label fw-bold small">Asunto</label>
                            <input type="text" id="asunto" name="asunto" 
                                class="form-control form-control-sm shadow-sm" 
                                placeholder="Ingrese el asunto">
                            @error('asunto')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Mensaje -->
                                                <div class="mb-3">
                            <label for="mensaje" class="form-label fw-bold small">Mensaje</label>
                            <textarea name="mensaje" id="mensaje" 
                                class="form-control form-control-sm shadow-sm" 
                                placeholder="Ingrese el mensaje" style="width: 100%; height: 150px;"></textarea>
                            @error('mensaje')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        <!-- Botón Enviar -->
                        <div class="text-center">
                        <button type="submit" class="btn btn-outline-success px-4 py-2 shadow-sm"><img src="{{ asset('src/images/enviar.png') }}" alt="Logo" style="max-width: 40px; margin-right: 10px;">Enviar Mensaje</button>

                        </div>
                    </form>

                    <!-- Mensaje de Éxito -->
                    @if (Session::has('info'))
                    <div class="alert alert-success mt-3 text-center">
                        {{ Session::get('info') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Scripts de Select2 -->
        <script>
            $(document).ready(function () {
                // Inicializar Select2 con soporte para etiquetas
                $('#correo_destino_select').select2({
                    tags: true,
                    placeholder: "",
                    allowClear: true,
                    tokenSeparators: [',', ' '],
                    width: '100%',
                });
            });

            const correoGerencia = "admin@correo.nutria.bo";

            function addGerencia() {
                const selectElement = $('#correo_destino_select');
                let exists = false;

                // Verificar si ya existe
                selectElement.find('option').each(function () {
                    if ($(this).val() === correoGerencia) {
                        exists = true;
                    }
                });

                // Añadir el correo o seleccionarlo
                if (!exists) {
                    const newOption = new Option(correoGerencia, correoGerencia, true, true);
                    selectElement.append(newOption).trigger('change');
                } else {
                    const currentValues = selectElement.val() || [];
                    currentValues.push(correoGerencia);
                    selectElement.val(currentValues).trigger('change');
                }
            }
        </script>
    </main>
</x-layout>
