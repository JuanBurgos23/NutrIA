@props(['bodyClass'])
<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>Tecno</title>

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
    <link rel="stylesheet" type="text/css" href="{{asset('src/plugins/datatables/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('src/plugins/datatables/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/styles/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('src/plugins/jquery-steps/jquery.steps.css')}}">
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>





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
    <style>
        .main-content {
            padding-left: 130px;
            margin-top: 40px;
            /* Ajusta el valor según el ancho del sidebar */
        }
    </style>

</head>

<body class="{{ $bodyClass }}">
    <!--  <div class="pre-loader">
        <div class="pre-loader-box">
            <div class="loader-logo"><img src="vendors/images/deskapp-logo.svg" alt=""></div>
            <div class='loader-progress' id="progress_div">
                <div class='bar' id='bar1'></div>
            </div>
            <div class='percent' id='percent1'>0%</div>
            <div class="loading-text">
                Loading...
            </div>
        </div>
    </div> -->

    <div class="header">
        <div class="header-left">
            <div class="menu-icon dw dw-menu"></div>
            <div class="search-toggle-icon dw dw-search2" data-toggle="header_search"></div>
            <div class="header-search">
                <form>
                    <div class="form-group mb-0">



                    </div>
                </form>
            </div>
        </div>
        <div class="header-right">
            <div class="dashboard-setting user-notification">
                <div class="dropdown">
                    <a class="dropdown-toggle no-arrow" href="javascript:;" data-toggle="right-sidebar">
                        <i class="dw dw-settings2"></i>
                    </a>
                </div>
            </div>
            <div class="user-notification">
                <div class="dropdown">
                    <a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
                        <i class="icon-copy dw dw-notification"></i>
                        <span class="badge bg-danger" id="notification-count">
                            {{ Auth::user()->mensajeNotificaciones()->where('read', false)->count() }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="notification-list mx-h-350 customscroll">
                            <ul>
                                @forelse (Auth::user()->mensajeNotificaciones()->where('read', false)->get() as $notification)
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;"
                                        onclick="markAsRead(event, {{ $notification->id }})">
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    Nuevo mensaje de: {{ $notification->data }}
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                @empty
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    No tienes mensajes.
                                                </h6>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                @endforelse

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user-info-dropdown">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        <span class="user-icon">
                            <img src="{{asset('vendors/images/photo1.jpg')}}" alt="">
                        </span>
                        <span class="user-name">{{auth::user()->name}}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                        <a class="dropdown-item" href="{{route('mensajesUser')}}"><i class="dw dw-user1"></i> Profile</a>

                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="right-sidebar">
        <div class="sidebar-title">
            <h3 class="weight-600 font-16 text-blue">
                Layout Settings
                <span class="btn-block font-weight-400 font-12">User Interface Settings</span>
            </h3>
            <div class="close-sidebar" data-toggle="right-sidebar-close">
                <i class="icon-copy ion-close-round"></i>
            </div>
        </div>
        <div class="right-sidebar-body customscroll">
            <div class="right-sidebar-body-content">
                <h4 class="weight-600 font-18 pb-10">Header Background</h4>
                <div class="sidebar-btn-group pb-30 mb-10">
                    <a href="javascript:void(0);" class="btn btn-outline-primary header-white active">White</a>
                    <a href="javascript:void(0);" class="btn btn-outline-primary header-dark">Dark</a>
                </div>

                <h4 class="weight-600 font-18 pb-10">Sidebar Background</h4>
                <div class="sidebar-btn-group pb-30 mb-10">
                    <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-light ">White</a>
                    <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-dark active">Dark</a>
                </div>

                <h4 class="weight-600 font-18 pb-10">Menu Dropdown Icon</h4>
                <div class="sidebar-radio-group pb-10 mb-10">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebaricon-1" name="menu-dropdown-icon" class="custom-control-input" value="icon-style-1" checked="">
                        <label class="custom-control-label" for="sidebaricon-1"><i class="fa fa-angle-down"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebaricon-2" name="menu-dropdown-icon" class="custom-control-input" value="icon-style-2">
                        <label class="custom-control-label" for="sidebaricon-2"><i class="ion-plus-round"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebaricon-3" name="menu-dropdown-icon" class="custom-control-input" value="icon-style-3">
                        <label class="custom-control-label" for="sidebaricon-3"><i class="fa fa-angle-double-right"></i></label>
                    </div>
                </div>

                <h4 class="weight-600 font-18 pb-10">Menu List Icon</h4>
                <div class="sidebar-radio-group pb-30 mb-10">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-1" name="menu-list-icon" class="custom-control-input" value="icon-list-style-1" checked="">
                        <label class="custom-control-label" for="sidebariconlist-1"><i class="ion-minus-round"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-2" name="menu-list-icon" class="custom-control-input" value="icon-list-style-2">
                        <label class="custom-control-label" for="sidebariconlist-2"><i class="fa fa-circle-o" aria-hidden="true"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-3" name="menu-list-icon" class="custom-control-input" value="icon-list-style-3">
                        <label class="custom-control-label" for="sidebariconlist-3"><i class="dw dw-check"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-4" name="menu-list-icon" class="custom-control-input" value="icon-list-style-4" checked="">
                        <label class="custom-control-label" for="sidebariconlist-4"><i class="icon-copy dw dw-next-2"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-5" name="menu-list-icon" class="custom-control-input" value="icon-list-style-5">
                        <label class="custom-control-label" for="sidebariconlist-5"><i class="dw dw-fast-forward-1"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-6" name="menu-list-icon" class="custom-control-input" value="icon-list-style-6">
                        <label class="custom-control-label" for="sidebariconlist-6"><i class="dw dw-next"></i></label>
                    </div>
                </div>

                <div class="reset-options pt-30 text-center">
                    <button class="btn btn-danger" id="reset-settings">Reset Settings</button>
                </div>
            </div>
        </div>
    </div>
    <div class="left-side-bar">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="{{ route('dashboard') }}" class="d-flex align-items-center">
                    <img src="{{asset('vendors/images/favicon.png')}}" alt="Logo" style="width: 40px; height: 40px; margin-right: 10px;">
                    <span style="font-size: 30px; font-weight: bold; color: white;">NUTRIA</span>
                </a>
            </div>
        </div>
        <div class="menu-block customscroll">
            <div class="sidebar-menu">
                <ul id="accordion-menu">

                    <li>
                        <a href="{{ route('dashboard') }}" class="dropdown-toggle no-arrow {{ Route::is('dashboard') ? 'active' : '' }}">
                            <span class="micon dw dw-house-1"></span><span class="mtext">Home</span>
                        </a>
                    </li>


                    @role('admin')
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon dw dw-edit2"></span><span class="mtext">Registros</span>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="{{ route('periodo') }}" class="dropdown-toggle no-arrow {{ Route::is('periodo') ? 'active' : '' }}">
                                    <span class="micon dw dw-notepad-2"></span><span class="mtext">Periodo</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('alimento') }}" class="dropdown-toggle no-arrow {{ Route::is('alimento') ? 'active' : '' }}">
                                    <span class="micon dw dw-notepad-2"></span><span class="mtext">Alimento</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('dieta') }}" class="dropdown-toggle no-arrow {{ Route::is('dieta') ? 'active' : '' }}">
                                    <span class="micon dw dw-notepad-2"></span><span class="mtext">Dieta</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('ejercicio') }}" class="dropdown-toggle no-arrow {{ Route::is('ejercicio') ? 'active' : '' }}">
                                    <span class="micon dw dw-notepad-2"></span><span class="mtext">Ejercicio</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="{{ route('mostrar_consulta') }}" class="dropdown-toggle no-arrow {{ Route::is('mostrar_consulta') ? 'active' : '' }}">
                            <span class="micon dw dw-notepad-2"></span><span class="mtext">Consultas</span>
                        </a>
                    </li>
                    @endrole
                    @role('paciente')
                    <li>
                        <a href="{{ route('registro') }}" class="dropdown-toggle no-arrow {{ Route::is('registro') || Route::is('plan_nutricional') ? 'active' : '' }}">
                            <span class="micon dw dw-notepad-2"></span><span class="mtext">Registrar Consulta</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('historial') }}" class="dropdown-toggle no-arrow {{ Route::is('historial') || Route::is('detalle_historial')  ? 'active' : '' }}">
                            <span class="micon dw dw-notepad-2"></span><span class="mtext">Historial</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reportar') }}" class="dropdown-toggle no-arrow {{ Route::is('reportar')  ? 'active' : '' }}">
                            <span class="micon dw dw-notepad-2"></span><span class="mtext">Reportar</span>
                        </a>
                    </li>
                    @endrole
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>

                </ul>
            </div>
        </div>
    </div>

    <div class="mobile-menu-overlay"></div>

    <div class="main-content">
        {{ $slot }}
    </div>

    <div class="main-container">




    </div>
    <!-- js -->
    <script src="{{asset('vendors/scripts/core.js')}}"></script>
    <script src="{{asset('vendors/scripts/script.min.js')}}"></script>
    <script src="{{asset('vendors/scripts/process.js')}}"></script>
    <script src="{{asset('vendors/scripts/layout-settings.js')}}"></script>
    <script src="{{asset('src/plugins/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{asset('src/plugins/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('src/plugins/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('src/plugins/datatables/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('src/plugins/datatables/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('vendors/scripts/dashboard.js')}}"></script>
    <script src="{{asset('src/plugins/jquery-steps/jquery.steps.js')}}"></script>
    <script src="{{asset('vendors/scripts/steps-setting.js')}}"></script>

    <!-- buttons for Export datatable -->
    <script src="{{asset('src/plugins/datatables/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('src/plugins/datatables/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('src/plugins/datatables/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('src/plugins/datatables/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('src/plugins/datatables/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('src/plugins/datatables/js/pdfmake.min.js')}}"></script>

    
    <script src="{{asset('src\plugins\datatables')}}" ></script>
    
    <!-- buttons for Export datatable -->
    
    <!-- Datatable Setting js -->
    <script src="{{asset('vendors/scripts/datatable-setting.js')}}"></script>
</body>
<script>
    function markAsRead(event, id) {
        event.preventDefault();
        fetch(`/mensajeUser/${id}/markAsRead`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirige a la vista del mensaje
                    window.location.href = data.redirect_url;
                }
            });
    }
</script>

@stack('js')

</body>

</html>