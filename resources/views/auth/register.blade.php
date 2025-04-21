<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>Nutr-IA</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('vendors/images/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('vendors/images/favicon.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('vendors/images/favicon.png')}}">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/styles/core.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/styles/icon-font.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('src/plugins/jquery-steps/jquery.steps.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/styles/style.css')}}">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-119386393-1');
    </script>
</head>

<body class="login-page">
    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
            <a href="login.html" class="d-flex align-items-center">
                <img src="vendors/images/favicon.png" alt="Logo" style="width: 30px; height: 30px; margin-right: 10px;">
                <span style="font-size: 20px; font-weight: bold; color: #333;">NUTRIA</span>
            </a>
            </div>
            <div class="login-menu">
                <ul>
                    <li><a href="{{ route('login') }}">Login</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="register-page-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <img src="{{asset('vendors/images/register.png')}}" alt="">
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="register-box bg-white box-shadow border-radius-10">
                        <div class="wizard-content">
                            <form method="POST" action="{{ route('register') }}" class="tab-wizard2 wizard-circle wizard">
                                @csrf
                                <h5>Credenciales de Cuenta</h5>
                                <section>
                                    <div class="form-wrap max-width-600 mx-auto">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Correo</label>
                                            <div class="col-sm-8">
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                                 <!-- Mensaje de recomendación -->
                                                 <small class="form-text text-muted">
                                                    Se recomienda usar un correo con el dominio <strong>@correo.nutria.bo</strong> para una mejor experiencia.
                                                </small>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Contraseña</label>
                                            <div class="col-sm-8">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Confirmar Contraseña</label>
                                            <div class="col-sm-8">
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-4 col-form-label">Sexo:</label>
                                            <div class="col-sm-8">
                                                <div class="custom-control custom-radio custom-control-inline pb-0">
                                                    <input type="radio" id="male" name="genero" value="masculino" class="custom-control-input">
                                                    <label class="custom-control-label" for="male">Masculino</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline pb-0">
                                                    <input type="radio" id="female" name="genero" value="femenino" class="custom-control-input">
                                                    <label class="custom-control-label" for="female">Femenino</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </section>
                                <!-- Step 2 -->
                                <h5>Informacion Personal</h5>
                                <section>
                                    <div class="form-wrap max-width-600 mx-auto">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Nombre</label>
                                            <div class="col-sm-8">
                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Paterno</label>
                                            <div class="col-sm-8">
                                                <input id="paterno" name="paterno" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Materno</label>
                                            <div class="col-sm-8">
                                                <input id="materno" name="materno" type="text" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Edad:</label>
                                            <div class="col-sm-8">
                                                <input id="edad" name="edad" type="number" class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                </section>
                                <!-- Step 3 -->

                                <!-- Step 4 -->
                                <h5>Informacion General</h5>
                                <section>
                                    <div class="form-wrap max-width-600 mx-auto">
                                        <ul class="register-info">
                                            <li>
                                                <div class="row">
                                                    <div class="col-sm-4 weight-600">Correo</div>
                                                    <div class="col-sm-8" id="displayEmail"></div>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="row">
                                                    <div class="col-sm-4 weight-600">Contraseña</div>
                                                    <div class="col-sm-8" id="displayPassword">.....000</div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-sm-4 weight-600">Nombre Completo</div>
                                                    <div class="col-sm-8" id="displayNombre"></div>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="row">
                                                    <div class="col-sm-4 weight-600">Edad</div>
                                                    <div class="col-sm-8" id="displayEdad"></div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-sm-4 weight-600">Sexo</div>
                                                    <div class="col-sm-8" id="displaySexo"></div>
                                                </div>
                                            </li>
                                        </ul>

                                    </div>

                                </section>
                                <div class="col-md-6 offset-md-4">
                                    <button id="success-modal-btn" hidden data-toggle="modal" data-target="#success-modal" data-backdrop="static" type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- success Popup html Start -->


    <div class="modal fade" id="success-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered max-width-400" role="document">
            <div class="modal-content">
                <div class="modal-body text-center font-18">
                    <h3 class="mb-20">Formulario Enviado!</h3>
                    <div class="mb-30 text-center"><img src="vendors/images/success.png"></div>
                    Su cuenta ha sido creado con exito!
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="{{ route('login') }}" class="btn btn-primary">Hecho</a>
                </div>
            </div>
        </div>
    </div>

    <!-- success Popup html End -->
    <!-- js -->
    <script src="{{asset('vendors/scripts/core.js')}}"></script>
    <script src="{{(asset('vendors/scripts/script.min.js'))}}"></script>
    <script src="{{asset('vendors/scripts/process.js')}}"></script>
    <script src="{{asset('vendors/scripts/layout-settings.js')}}"></script>
    <script src="{{asset('src/plugins/jquery-steps/jquery.steps.js')}}"></script>
    <script src="{{asset('vendors/scripts/steps-setting.js')}}"></script>
    <script>
        $(document).ready(function() {
            // Escuchar el evento cuando cambias de sección en el wizard
            $('.wizard').on('stepChanged', function(event, currentIndex) {
                // Verificar si estamos en la última sección (índice del paso final, asumiendo que es el 2)
                if ($('.wizard').steps("getCurrentIndex") === 2) {
                    // Obtener los valores de los campos
                    var email = $('#email').val();
                    var password = $('#password').val();
                    var nombre = $('#name').val();
                    var paterno = $('#paterno').val();
                    var materno = $('#materno').val();
                    var edad = $('#edad').val();

                    var sexo = $("input[name='genero']:checked").next('label').text();

                    // Mostrar los valores en la sección de "Información General"
                    $('#displayEmail').text(email);
                    $('#displayPassword').text('.....' + password.slice(-3));
                    $('#displayNombre').text(nombre + ' ' + paterno + ' ' + materno); // Asegúrate de que el ID sea correcto
                    $('#displayEdad').text(edad);
                    $('#displaySexo').text(sexo);
                }
            });
        });
    </script>

</body>

</html>