<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    </head>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f8f9fa;
                color: #343a40;
            }

            .icon {
                font-family: "Font Awesome 5 Free";
            }




            .section-title {
                background-color: #004085;
                color: white;
                padding: 10px;
                border-radius: 10px 10px 0 0;
                text-align: center;
                margin-bottom: 0;
            }

            .content {
                background-color: white;
                padding: 20px;
                border-radius: 0 0 10px 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .table th {
                background-color: #e9ecef;
            }

            .table-hover tbody tr:hover {
                background-color: #f1f1f1;
            }

            .btn-primary {
                background-color: #004085;
                border: none;
                margin: 20px 0;
            }

            .btn-primary:hover {
                background-color: #002752;
            }

            .food-metrics i {
                margin-right: 5px;
                color: #007bff;
            }

            .food-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px;
                border-radius: 10px;
                background-color: #fff;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                margin-bottom: 10px;
            }

            .food-info {
                display: flex;
                flex-direction: column;
            }

            .food-name {
                font-weight: bold;
                font-size: 1.1em;
            }

            .food-metrics {
                display: flex;
                gap: 15px;
                color: #6c757d;
            }

            .food-metrics i {
                margin-right: 5px;
                color: #007bff;
            }

            .calories {
                font-weight: bold;
                font-size: 1.2em;

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
                    <div class="container mt-5">
                        <div class="card shadow-lg border-0 rounded-lg">
                            <!-- Título principal -->
                            <div class="section-title">
                                <h2 style="color: #e9ecef;" class="mb-0">Plan Nutricional</h2>
                            </div>

                            <!-- Menú desplegable -->
                            <div class="p-4">
                                <label for="mealSelect" class="form-label">Selecciona una comida:</label>
                                <select id="mealSelect" class="form-select">
                                    <option value="desayuno" selected>Desayuno</option>
                                    <option value="almuerzo">Almuerzo</option>
                                    <option value="cena">Cena</option>
                                    <option value="merienda">Merienda</option>
                                </select>
                            </div>

                            <!-- Contenedor para mostrar la información -->
                            <div id="mealContent" class="p-4">
                                <!-- Contenido de las comidas -->
                                @php
                                $comidas = [
                                'desayuno' => $planNutricional->dieta->detalleDietas2->filter(fn($detalle) => \Carbon\Carbon::parse($detalle->horario->hora)->between('06:00', '10:00')),
                                'almuerzo' => $planNutricional->dieta->detalleDietas2->filter(fn($detalle) => \Carbon\Carbon::parse($detalle->horario->hora)->between('12:00', '15:00')),
                                'cena' => $planNutricional->dieta->detalleDietas2->filter(fn($detalle) => \Carbon\Carbon::parse($detalle->horario->hora)->between('18:00', '21:00')),
                                'merienda' => $planNutricional->dieta->detalleDietas2->filter(fn($detalle) => !\Carbon\Carbon::parse($detalle->horario->hora)->between('06:00', '21:00')),
                                ];
                                @endphp

                                @foreach($comidas as $tipo => $detalles)
                                <div id="{{ $tipo }}-content" class="meal-details" style="display: none;">
                                    <h3 class="text-center mb-4">{{ ucfirst($tipo) }}</h3>
                                    @if($detalles->isEmpty())
                                    <p class="text-center text-muted">No hay datos disponibles.</p>
                                    @else
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Alimento</th>
                                                <th>Carbs</th>
                                                <th>Grasa</th>
                                                <th>Proteína</th>
                                                <th>Día</th>
                                                <th>Hora</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($detalles as $detalle)
                                            <tr>
                                                <td>
                                                    {{ $detalle->alimento->nombre }}
                                                </td>
                                                <td>
                                                    <i class="fa-solid fa-bread-slice" style="color: #f39c12;"></i>
                                                    {{ $detalle->alimento->carbohidrato }}g
                                                </td>
                                                <td>
                                                    <i class="fa-solid fa-bacon" style="color: #e74c3c;"></i>
                                                    {{ $detalle->alimento->grasa }}g
                                                </td>
                                                <td>
                                                    <i class="fa-solid fa-fish" style="color: #3498db;"></i>
                                                    {{ $detalle->alimento->proteina }}g
                                                </td>
                                                <td>
                                                    <i class="fa-solid fa-calendar-days" style="color: #f39c12;"></i>
                                                    {{ $detalle->dia->nombre }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($detalle->horario->hora)->format('H:i') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @endif
                                </div>
                                @endforeach
                            </div>

                            <!-- Script para manejar el select -->
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const mealSelect = document.getElementById('mealSelect');
                                    const allContents = document.querySelectorAll('.meal-details');

                                    function showMealContent() {
                                        allContents.forEach(content => content.style.display = 'none'); // Ocultar todos
                                        const selectedMeal = mealSelect.value;
                                        document.getElementById(selectedMeal + '-content').style.display = 'block'; // Mostrar seleccionado
                                    }

                                    // Mostrar la comida seleccionada al inicio
                                    showMealContent();

                                    // Evento al cambiar la opción
                                    mealSelect.addEventListener('change', showMealContent);
                                });
                            </script>
                            <!-- Ejercicios asociados al Plan Nutricional -->
                            <!-- Exercise Section -->
                            <div class="card mt-4">
                                <div class="section-title">
                                    <h3 style="color: #e9ecef;">Tipo de Ejercicio Recomendado:</h3>
                                    <h3 style="color: #e9ecef;">{{ $planNutricional->ejercicios->first()->tipoEjercicio->nombre }} <i class="fa-solid fa-dumbbell"></i></h3>
                                </div>
                                <div class="content">
                                    <table class="table table-bordered table-hover">
                                        <tbody>
                                            @foreach($planNutricional->ejercicios as $ejercicio)
                                            <tr>
                                                <td>
                                                    <div class="food-item">
                                                        <div class="food-info">
                                                            <div class="food-name">
                                                                <strong>{{ $ejercicio->nombre }}</strong> -
                                                            </div>
                                                            <div class="food-metrics">
                                                                <span><i class="fa-solid fa-calendar-days" style="color: #f39c12;"></i> Días:
                                                                    @foreach ($ejercicio->dias as $dia)
                                                                    {{ $dia->nombre }}@if(!$loop->last), @endif
                                                                    @endforeach
                                                                </span>
                                                                <span><i class="fa-solid fa-recycle" style="color: #e74c3c;"></i> Series: {{ $ejercicio->series }}</span>
                                                                <span><i class="fa-solid fa-repeat" style="color: #3498db;"></i> Repeticiones: {{ $ejercicio->repeticiones }}</span>
                                                                <span><i class="fa-solid fa-hourglass-half" style="color: #2ecc71;"></i> Descanso: {{ $ejercicio->descanso }} seg</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Pie de página con botón de impresión -->
                        <div class="card-footer text-center bg-light">
                            <a href="{{ route('plan_pdf', $planNutricional->id) }}" class="btn btn-success">Generar PDF</a>
                        </div>
                        <div class="card-footer text-center bg-light">

                            <a href="{{ route('historial')}}" class="btn btn-success">Volver al Historial</a>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
</x-layout>