<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <head>

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
                            <div class="card-header bg-primary text-white text-center">
                                <h2 class="mb-0">Resultado del Diagnóstico</h2>
                            </div>
                            <div class="card-body p-5">
                                <p class="lead text-justify" style="font-size: 1.2rem;">
                                    {{ $diagnosticos->detalle }}
                                </p>
                            </div>
                            <div class="card-footer text-center bg-light">
                                <button onclick="window.print()" class="btn btn-outline-primary">
                                    Imprimir Diagnóstico
                                </button>
                                <a href="{{ route('historial')}}"class="btn btn-success">Volver al Historial</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>