<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <head>
        <style>
            /* General styles */
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #f8f9fa;
                color: #333;
            }

            .container-fluid {
                max-width: 900px;
                margin-top: 50px;
            }

            .card {
                border-radius: 16px;
                border: none;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                background-color: #ffffff;
                padding: 40px;
                margin-bottom: 30px;
            }

            .card-header {
                background-color: #007bff;
                color: #fff;
                font-size: 28px;
                font-weight: 700;
                padding: 16px;
                border-radius: 10px;
            }

            .form-group {
                margin-bottom: 1.5rem;
            }

            label {
                font-size: 16px;
                font-weight: 500;
                color: #555;
                margin-bottom: 10px;
            }

            .form-control {
                border-radius: 8px;
                border: 1px solid #ddd;
                font-size: 16px;
                padding: 12px;
                box-shadow: none;
                transition: border-color 0.3s, box-shadow 0.3s;
            }

            .form-control:focus {
                border-color: #007bff;
                box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            }

            .btn-primary {
                background-color: #007bff;
                border-color: #007bff;
                border-radius: 30px;
                font-size: 16px;
                font-weight: 500;
                padding: 12px 24px;
                text-transform: uppercase;
                transition: background-color 0.3s;
                width: 100%;
            }

            .btn-primary:hover {
                background-color: #0056b3;
                border-color: #0056b3;
            }

            .alert {
                border-radius: 8px;
                margin-bottom: 20px;
            }

            .alert-success {
                background-color: #d4edda;
                color: #155724;
                border-color: #c3e6cb;
            }

            /* Responsive styles */
            @media (max-width: 768px) {
                .container-fluid {
                    padding: 20px;
                }

                .card {
                    padding: 25px;
                }

                .btn-primary {
                    font-size: 14px;
                    padding: 10px;
                }
            }
        </style>
    </head>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="col-12">
                <div class="card">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    <div class="card-header">
                        Realiza tu Consulta
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{route('registrar_consulta')}}">
                            @csrf
                            <div class="form-group row align-items-center">
    <!-- Ícono -->
    <div class="col-sm-12 col-md-1">
        <img src="{{ asset('src/images/pensando.png') }}" alt="Logo Fecha" style="max-width: 30px;">
    </div>

    <!-- Etiqueta y campo de texto -->
    <label for="motivo" class="col-sm-12 col-md-2 col-form-label">Motivo</label>
    <div class="col-sm-12 col-md-9">
        <input class="form-control" id="motivo" type="text" name="motivo" required placeholder="Ingresa el motivo de la consulta">
    </div>
</div>

                            <div class="form-group row align-items-center">
    <!-- Ícono -->
    <div class="col-sm-12 col-md-1">
        <img src="{{ asset('src/images/nutrilogo.png') }}" alt="Logo Fecha" style="max-width: 30px;">
    </div>

    <!-- Etiqueta y campo de selección (dropdown) -->
    <label for="objetivo" class="col-sm-12 col-md-2 col-form-label">Objetivo</label>
    <div class="col-sm-12 col-md-9">
        <select class="form-control" id="objetivo" name="objetivo" required>
            <option value="" disabled selected>Selecciona un objetivo</option>
            <option value="subir de peso">Subir de peso</option>
            <option value="bajar de peso">Bajar de peso</option>
            <option value="mantener el peso">Mantener el peso</option>
        </select>
    </div>
</div>

                            <div class="form-group row align-items-center">
    <!-- Ícono -->
    <div class="col-sm-12 col-md-1">
        <img src="{{ asset('src/images/logofecha.png') }}" alt="Logo Fecha" style="max-width: 30px;">
    </div>
    
    <!-- Etiqueta y campo de fecha -->
    <label for="fecha_consulta" class="col-sm-12 col-md-2 col-form-label">Fecha</label>
    <div class="col-sm-12 col-md-9">
        <input class="form-control" id="fecha_consulta" name="fecha_consulta" type="date" required>
    </div>
</div>
<button type="submit" class="btn btn-primary d-flex justify-content-center align-items-center" style="font-size: 16px; padding: 8px 15px;">
    <img src="{{ asset('src/images/robotnutri.png') }}" alt="Logo" style="max-width: 120px; margin-right: 10px;">
    Realiza tu consulta
</button>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
