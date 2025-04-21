<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan Nutricional</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="{{public_path('styles/all.mic.css')}}">

    <style>
        @media print {
            .no-print {
                display: none;
            }

            .fa-solid {
                /* Si no defines estilos aquí, mantendrán su formato original */
                font-family: "Font Awesome 6 Free";
                /* Asegura que los íconos se rendericen correctamente */
                font-weight: 900;
                /* Necesario para íconos sólidos */
            }
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }

        .icon {
            font-family: "Font Awesome 5 Free";
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #004085;
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .header img {
            height: 60px;
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
</head>

<body>
    @php
    $detalles = $planNutricional->dieta->detalleDietas2;

    // Clasificar detalles en desayuno, almuerzo, cena
    $desayuno = $detalles->filter(function($detalle) {
    return \Carbon\Carbon::parse($detalle->horario->hora)->between('06:00', '10:00');
    });

    $almuerzo = $detalles->filter(function($detalle) {
    return \Carbon\Carbon::parse($detalle->horario->hora)->between('12:00', '15:00');
    });

    $cena = $detalles->filter(function($detalle) {
    return \Carbon\Carbon::parse($detalle->horario->hora)->between('18:00', '21:00');
    });
    @endphp
    <div class="container mt-4">
        <!-- Header with Logo and Company Name -->
        <div class="header">
            <div>
                <h1>Plan Nutricional</h1>
                <h4>Fecha Inicio: {{ $planNutricional->periodo->fecha_inicio }}</h4>
                <h4>Fecha Final: {{ $planNutricional->periodo->fecha_fin }}</h4>
                <h4>Paciente: {{ auth()->user()->paciente->nombre_completo }}</h4>
            </div>
            <div>
                <img src="/public/vendors/images/favicon.png" alt="Logo de la empresa">
                <h4>Nutr-IA</h4>
            </div>
        </div>

        <!-- Desayuno Section -->
        <div class="card mt-4">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <div class="section-title">
                <h3>Desayuno</h3>
            </div>
            <div class="content">
                <table class="table table-bordered table-hover">

                    <tbody>
                        @foreach ($desayuno as $detalle)
                        <div class="food-item">
                            <div class="food-info">
                                <div class="food-name">{{ $detalle->alimento->nombre }}</div>

                                <div class="food-metrics">
                                    <span><i class="fa-solid fa-bread-slice" style="color: #f39c12;"></i> Carbs: {{ $detalle->alimento->carbohidrato }}g</span>
                                    <span><i class="fa-solid fa-bacon" style="color: #e74c3c;"></i> Grasa: {{ $detalle->alimento->grasa }}g</span>
                                    <span><i class="fa-solid fa-fish" style="color: #3498db;"></i> Protein: {{ $detalle->alimento->proteina }}g</span>
                                </div>
                            </div>
                            <div class="calories">{{ $detalle->alimento->caloria }} Cals <i class="fa-solid fa-fire"></i></div>
                            <div class="calories">Dia: {{ $detalle->dia->nombre }}
                                <span>Hora: {{ \Carbon\Carbon::parse($detalle->horario->hora)->format('H:i')}}</span>
                            </div>

                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Almuerzo Section -->
        <div class="card mt-4">
            <div class="section-title">
                <h3>Almuerzo</h3>
            </div>
            <div class="content">
                <table class="table table-bordered table-hover">

                    <tbody>
                        @foreach ($almuerzo as $detalle)
                        <div class="food-item">
                            <div class="food-info">
                                <div class="food-name">{{ $detalle->alimento->nombre }}</div>
                                <div class="food-metrics">
                                    <span><i class="fa-solid fa-bread-slice" style="color: #f39c12;"></i> Carbs: {{ $detalle->alimento->carbohidrato }}g</span>
                                    <span><i class="fa-solid fa-bacon" style="color: #e74c3c;"></i> Grasa: {{ $detalle->alimento->grasa }}g</span>
                                    <span><i class="fa-solid fa-fish" style="color: #3498db;"></i> Protein: {{ $detalle->alimento->proteina }}g</span>
                                </div>
                            </div>
                            <div class="calories text-center">{{ $detalle->alimento->caloria }} Cals <i class="fa-solid fa-fire"></i></div>
                            <div class="calories">Dia: {{ $detalle->dia->nombre }}
                                <span>Hora: {{ \Carbon\Carbon::parse($detalle->horario->hora)->format('H:i')}}</span>
                            </div>

                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Cena Section -->
        <div class="card mt-4">
            <div class="section-title">
                <h3>Cena</h3>
            </div>
            <div class="content">
                <table class="table table-bordered table-hover">

                    <tbody>
                        @foreach ($cena as $detalle)
                        <div class="food-item">
                            <div class="food-info">
                                <div class="food-name">{{ $detalle->alimento->nombre }}</div>
                                <div class="food-metrics">
                                    <span><i class="fa-solid fa-bread-slice" style="color: #f39c12;"></i> Carbs: {{ $detalle->alimento->carbohidrato }}g</span>
                                    <span><i class="fa-solid fa-bacon" style="color: #e74c3c;"></i> Grasa: {{ $detalle->alimento->grasa }}g</span>
                                    <span><i class="fa-solid fa-fish" style="color: #3498db;"></i> Protein: {{ $detalle->alimento->proteina }}g</span>
                                </div>
                            </div>
                            <div class="calories">{{ $detalle->alimento->caloria }} Cals <i class="fa-solid fa-fire"></i></div>
                            <div class="calories">Dia: {{ $detalle->dia->nombre }}
                                <span>Hora: {{ \Carbon\Carbon::parse($detalle->horario->hora)->format('H:i')}}</span>
                            </div>

                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Exercise Section -->
        <div class="card mt-4">
            <div class="section-title">
                <h3>Tipo de Ejercicio Recomendado:</h3>
                <h3>{{ $planNutricional->ejercicios->first()->tipoEjercicio->nombre }} <i class="fa-solid fa-dumbbell"></i></h3>
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


        <!-- Enviar Plan Button -->
        <form action="{{ route('enviarPlanCorreo', $planNutricional->id) }}" method="post" class="text-end no-print">
            @csrf
            <button type="submit" class="btn btn-primary no-print">Enviar Plan por Correo</button>
        </form>
    </div>
</body>

</html>