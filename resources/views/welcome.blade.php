<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan Nutricional y Ejercicio</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('vendors/images/fondos.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff; /* Cambié el color a blanco para mejor visibilidad */
            margin: 0;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }
        header {
            text-align: center;
            padding: 40px;
            background: rgba(0, 0, 50, 0.7);
            color: #e0f7fa;
            position: relative;
            border-bottom: 5px solid #00bfff;
        }

        header nav {
            margin-top: 20px;
        }
        header nav a {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
          
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        header nav a:hover {
           
            transform: scale(1.1);
        }

        header h1 {
            font-size: 3rem;
            margin: 20px 0;
            font-weight: bold;
            animation: bounce 2s infinite;
            font-family: 'Poppins', sans-serif;
        }
        header img {
            max-width: 150px;
            border-radius: 50%;
            margin-bottom: 20px;
        }
        .auth-container {
            position: absolute;
            top: 20px;
            right: 20px;
    
            padding: 20px;
            border-radius: 10px;
          /* box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); */
            animation: slide-in 1s ease-out;
            display: flex;
            align-items: center;
            gap: 10px; /* Espacio entre los elementos */
         }

        .auth-container a {
            display: block;
            margin: 10px 0;
            padding: 10px;
            background: #00bfff;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-family: 'Roboto', sans-serif;
        }
        .auth-container a:hover {
            background: #008ac9;
            transform: scale(1.05);
        }
        .content {
            flex: 1;
            text-align: center;
            padding: 40px 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            margin: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .content img {
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }
        .content h2 {
            margin: 20px 0;
            color: #008ac9;
            font-size: 2.5rem;
            font-family: 'Poppins', sans-serif;
        }
        .content p {
            color: #000; /* Cambié el color del texto a negro */
            font-family: 'Roboto', sans-serif;
            font-size: 1.2rem;
            line-height: 1.6;
        }
        .slider-container {
            overflow-x: auto;
            white-space: nowrap;
            padding: 20px;
            background: rgba(0, 0, 50, 0.1);
            border-radius: 10px;
            margin: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .slider-container h3 {
            color: #fff;
            font-size: 2rem;
            margin-bottom: 15px;
            font-family: 'Poppins', sans-serif;
        }
        .slider-container .item {
            display: inline-block;
            margin: 0 15px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s ease;
            border-radius: 10px;
            padding: 10px;
        }
        .slider-container .item:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .slider-container img {
            max-width: 250px;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .comments {
            padding: 120px;
            
            color: #333;
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .comments h3 {
            margin-bottom: 20px;
            color: #008ac9;
            font-size: 2rem;
            font-family: 'Poppins', sans-serif;
        }
        .comment {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            padding: 15px;
            background: #f1f1f1;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .comment img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 15px;
        }
        .comment p {
            margin: 0;
            font-weight: bold;
            color: #333;
            font-size: 1.1rem;
        }
        .comment .stars {
            color: #ffd700;
            margin-left: auto;
        }
        footer {
            text-align: center;
            padding: 20px;
            background: rgba(0, 0, 50, 0.7);
            color: #e0f7fa;
            font-family: 'Roboto', sans-serif;
        }
        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        @keyframes slide-in {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .sobre-nosotros-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 40px;
            margin: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
        }
        .sobre-nosotros-container img {
            max-width: 50%;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }
        .sobre-nosotros-texto {
            max-width: 45%;
            font-family: 'Roboto', sans-serif;
            color: #333;
            font-size: 1.2rem;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <header>
    <nav>
            <a href="#explora">Alimentos y Ejercicios</a>
            <a href="#sobre-nosotros">Sobre Nosotros</a>
            <a href="#comentarios">Comentarios</a>
        </nav>
        <img src="vendors/images/aple.png" alt="Logo">
        <h1>Bienvenidos a NUTRIA</h1>
        <p>Tu salud, nuestro compromiso</p>
    </header>

    <div class="auth-container">
        <a href="{{ route('login') }}">Iniciar Sesión</a>
        <a href="{{ route('register') }}">Registrarse</a>
    </div>

    <div class="content">
        <img src="vendors/images/banner.png" alt="Nutrición y Ejercicio">
        <h2>Mejora tu salud con un plan integral</h2>
        <p>Descubre la combinación perfecta de nutrición y ejercicio para alcanzar tus metas de bienestar. Nuestro plan incluye recomendaciones personalizadas para optimizar tu salud y rendimiento.</p>
    </div>

    <div id="explora" class="slider-container">
        <h3>Explora Alimentos y Ejercicios</h3>
        <div class="item">
            <img src="vendors/images/frutass.jpg" alt="Frutas">
            <p><strong>Frutas Frescas</strong> </p>
        </div>
        <div class="item">
            <img src="vendors/images/vegetales.jpg" alt="Vegetales">
            <p><strong>Vegetales</strong> </p>
        </div>
        <div class="item">
            <img src="vendors/images/cardio.jpg" alt="Cardio">
            <p><strong>Ejercicios Cardiovasculares</strong> </p>
        </div>
        <div class="item">
            <img src="vendors/images/pesas.jpg" alt="Pesas">
            <p><strong>Entrenamiento con Pesas</strong></p>
        </div>
    </div>

    <div id="sobre-nosotros" class="sobre-nosotros-container">
        <div class="sobre-nosotros-texto">
        
        <h2>Sobre nosotros</h2>
        <p> En NUTRIA, creemos que la salud y el bienestar son pilares fundamentales para una vida plena. Somos un equipo apasionado por la nutrición, el ejercicio y la tecnología, comprometidos en ofrecer soluciones personalizadas y efectivas para mejorar la calidad de vida de nuestros usuarios.

Nuestro sistema combina conocimientos científicos sobre dietas y ejercicios con tecnología avanzada, incluyendo inteligencia artificial, para diseñar planes personalizados que se adaptan a las necesidades específicas de cada persona. Desde el control de peso hasta la mejora del rendimiento físico, nos enfocamos en brindar herramientas que promuevan hábitos saludables y sostenibles.

Con NUTRIA, no solo obtendrás un plan nutricional y de ejercicios, sino también un aliado en tu camino hacia un estilo de vida más saludable. Juntos, transformaremos tus metas en realidad, ofreciéndote soluciones que se ajusten a tu estilo de vida y objetivos.

¡Bienvenido a un futuro más saludable con NUTRIA!</p>
</div>
<img src="vendors/images/plan.png" alt="Frutas">

    </div>

    <div id="comentarios" class="comments">
        <h3>Lo que dicen nuestros usuarios</h3>
        <div class="comment">
            <img src="vendors/images/photo6.jpg" alt="Usuario 1">
            <p><strong>Juan Pérez:</strong> ¡El mejor plan que he probado!</p>
            <span class="stars">★★★★★</span>
        </div>
        <div class="comment">
            <img src="vendors/images/photo3.jpg" alt="Usuario 2">
            <p><strong>Ana García:</strong> Me siento con más energía y control sobre mi salud.</p>
            <span class="stars">★★★★☆</span>
        </div>
        <div class="comment">
            <img src="vendors/images/photo5.jpg" alt="Usuario 2">
            <p><strong>Mateo Gomez:</strong> ¡ Me encanta este sistema!.</p>
            <span class="stars">★★★★☆</span>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 NUTRIA. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
