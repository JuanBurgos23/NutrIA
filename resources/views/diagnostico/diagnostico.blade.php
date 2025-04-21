<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <head>
        <!-- Asegúrate de incluir Bootstrap o tu framework CSS preferido si no está ya en el layout -->
    </head>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="col-12">
                <div class="card my-4">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="container mt-5">
                        <div class="card shadow-lg border-0 rounded-lg">
                            <!-- Título principal -->
                            <div class="card-header bg-primary text-white text-center">
                                <h2 class="mb-0">Resultado del Diagnóstico</h2>
                            </div>

                            <!-- Detalles del diagnóstico -->
                            <div class="card-body p-5">
                                <h4 class="text-secondary mb-4">Detalles del Diagnóstico</h4>
                                <p class="lead text-justify" style="font-size: 1.2rem;">
                                    {{ $diagnostico->detalle }}
                                </p>

                                <!-- Separador -->
                                <hr class="my-4">

                                <!-- Recomendaciones -->
                                <h4 class="text-secondary mb-4">Recomendaciones</h4>
                                <ul class="list-group list-group-flush" style="font-size: 1.1rem;">
                                    @foreach(explode("\n", $diagnostico->recomendacion) as $recomendacion)
                                    <li class="list-group-item">
                                        {{ $recomendacion }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Pie de página con botón de impresión -->
                            <div class="card-footer text-center bg-light">
                                <button onclick="window.print()" class="btn btn-outline-primary">
                                    Imprimir Diagnóstico
                                </button>
                            </div>
                            <form method="POST" action="{{ route('plan') }}">
                                @csrf
                                <input type="hidden" name="diagnostico_id" value="{{ $diagnostico->id }}">
                                <!-- Campos ocultos para enviar detalles y recomendaciones -->
                                <input type="hidden" name="detalle" value="{{ $diagnostico->detalle }}">
                                <input type="hidden" name="recomendacion" value="{{ $diagnostico->recomendacion }}">

                                <!-- Botón para enviar el formulario -->
                                <div class="card-footer text-center bg-light">
                                    <button type="submit" class="btn btn-outline-primary">
                                        Crear Plan Nutricional
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>