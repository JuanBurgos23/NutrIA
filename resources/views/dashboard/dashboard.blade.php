<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <style>
        /* Estilo general */
        body {
            background-color: #f0f4f8; /* Fondo claro */
        }

        /* Ajustes generales */
        .main-container {
            padding: 0;
            margin: 0 auto;
            max-width: 80%;
        }

        .pd-ltr-20 {
            padding: 20px;
        }

        /* Ajustes para tarjetas */
        .card {
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: scale(1.05);
        }

        /* Estilo para la lista de usuarios */
        .usuarios-container {
            max-height: 600px; /* Altura máxima del contenedor */
            overflow-y: auto; /* Scroll vertical si excede el tamaño */
            padding: 15px;
            background-color: #aed6f1;
            border: 1px solid #aed6f1;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Título fijo en la lista de usuarios */
        .usuarios-container h2 {
            position: sticky;
            top: 0; /* Siempre visible en la parte superior */
            background-color: #aed6f1;
            margin: 0;
            padding: 10px 0;
            z-index: 1; /* Asegura que quede por encima del contenido */
            text-align: center;
            border-bottom: 1px solid #ccc; /* Opcional: línea separadora */
        }

        /* Ajustes para pantallas pequeñas */
        @media (max-width: 768px) {
            .main-container {
                padding: 10px;
            }
        }
    </style>
    <body>
        <div class="main-container">
            <div class="pd-ltr-20">
                <!-- Bienvenida -->
                <div class="card-box pd-20 height-100-p mb-30">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <img src="vendors/images/banner.png" alt="Banner" class="img-fluid" />
                        </div>
                        <div class="col-md-8">
                            <h4 class="font-20 weight-500 mb-10 text-capitalize">
                                BIENVENIDO/A
                                <div class="weight-600 font-30 text-blue">
                                    {{ Auth::user()->name }}!
                                </div>
                            </h4>
                            <p class="font-18 max-width-600">
                                Nos alegra que hayas elegido NUTRIA para acompañarte en tu camino hacia una vida más saludable. En nuestro sistema, te proporcionamos planes de nutrición y ejercicio personalizados, adaptados a tus necesidades y objetivos.
                                <br>
                                ¿Listo para empezar? ¡Tu viaje hacia un estilo de vida más saludable comienza ahora! Recuerda, en NUTRIA, cada paso cuenta.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Contenido principal -->
                <div class="row g-4">
                    <!-- Lista de usuarios -->
                    <div class="col-md-6" style="height: 500px;">
                        <div class="card h-100" style="height: 500px;">
                            <div class="usuarios-container" style="height: 500px;" >
                                <h2>Usuarios de Nutria</h2>
                                @if(isset($pacientes) && $pacientes->isNotEmpty())
                                <div class="list-group">
                                    @foreach($pacientes as $paciente)
                                    <div class="list-group-item d-flex align-items-center shadow-sm p-2 mb-2 bg-white rounded" style="border: 1px solid black; ">
                                        <!-- Imagen del usuario -->
                                        <img src="{{ asset('src/images/file.png') }}" alt="Imagen del usuario" class="rounded-circle mr-3" style="width: 50px; height: 50px; object-fit: cover;">
                                        <!-- Información del usuario -->
                                        <div class="ml-2">
                                            <h6 class="mb-1" style="font-size: 14px;">{{ $paciente->nombre_completo }}</h6>
                                            <p class="mb-0 text-muted" style="font-size: 12px;">{{ $paciente->user->email }}</p>
                                            <p class="mb-0 text-muted" style="font-size: 12px;">{{ $paciente->celular }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <p class="text-center">No hay pacientes registrados en el sistema.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Imagen 1 -->
                    <div class="col-md-6" style="height: 500px;">
                        <div class="card h-100 shadow" style="height: 500px;">
                            <img src="vendors/images/consulta.png" class="card-img-top" alt="Consulta" style="height: 390px;">
                            <div class="card-body text-center">
                                <h5 class="card-title">Realiza Consultas</h5>
                                <p class="card-text">
                                Consulta Personalizada para Mejorar tu Salud y Bienestar
                                Accede a un plan diseñado a la medida de tus objetivos y necesidades.                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Segunda fila de imágenes -->
                <div class="row g-4 mt-4">
                    <!-- Imagen 2 -->
                    <div class="col-md-6">
                        <div class="card h-100 shadow">
                            <img src="vendors/images/ejercicioss.png" class="card-img-top" alt="Ejercicios" style="height: 400px;">
                            <div class="card-body text-center">
                                <h5 class="card-title">Ejercicios</h5>
                                <p class="card-text">
                                    Descubre ejercicios adaptados a tu nivel y condición física para mejorar tu bienestar.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Imagen 3 -->
                    <div class="col-md-6">
                        <div class="card h-100 shadow">
                        <img src="vendors/images/recetas.jpg" class="card-img-top" alt="Plan Nutricional" style="height: 400px;">
                            <div class="card-body text-center">
                                <h5 class="card-title">Plan Nutricional</h5>
                                <p class="card-text">
                                    Personaliza tu plan nutricional con recetas saludables y sigue las recomendaciones para alcanzar tus metas.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pie de página -->
                <footer class="mt-5 text-center text-muted">
                    <p>&copy; 2024 NUTRIA. Todos los derechos reservados.</p>
                </footer>
            </div>
        </div>
    </body>
</x-layout>
