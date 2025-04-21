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
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
                            <div class="pd-20 card-box height-100-p">
                                <div class="profile-photo">
                                    <a href="modal" data-toggle="modal" data-target="#modal" class="edit-avatar"><i class="fa fa-pencil"></i></a>
                                    <img src="vendors/images/photo1.jpg" alt="" class="avatar-photo">
                                    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body pd-5">
                                                    <div class="img-container">
                                                        <img id="image" src="vendors/images/photo2.jpg" alt="Picture">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="submit" value="Update" class="btn btn-primary">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="text-center h5 mb-0">{{auth::user()->name}}</h5>
                                <p class="text-center text-muted font-14"> @foreach(auth()->user()->roles as $role)
                                    {{ $role->name }}
                                    @endforeach
                                </p>
                                <div class="profile-info">
                                    <h5 class="mb-20 h5 text-blue">Información del contacto</h5>
                                    <ul>

                                        <li>
                                            <span>Dirección de correo electrónico:</span>
                                            {{auth::user()->email}}
                                        </li>
                                        @if ($paciente)
                                        <li>
                                            <span>Celular:</span>
                                            {{$paciente->celular ?? 'N/A'}}
                                        </li>
                                        <li>
                                            <span>Fecha de Nacimiento:</span>
                                            {{$paciente->fecha_nac ?? 'N/A'}}
                                        </li>
                                        <li>
                                            <span>Direccion:</span>
                                            {{$paciente->direccion ?? 'N/A'}}
                                        </li>
                                        @endif


                                    </ul>
                                </div>


                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
                            <div class="card-box height-100-p overflow-hidden">
                                <div class="profile-tab height-100-p">
                                    <div class="tab height-100-p">
                                        <ul class="nav nav-tabs customtab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#setting" role="tab">Perfil</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#tasks" role="tab">Mensajes</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">

                                            <!-- Setting Tab start -->
                                            <div class="tab-pane fade height-100-p fade show active" id="setting" role="tabpanel">
                                                <div class="profile-setting">
                                                    <form method="POST" action="{{ route('user-perfil') }}">
                                                        @csrf
                                                        <ul class="profile-edit-list row">
                                                            <li class="weight-500 col-md-6">
                                                                <h4 class="text-blue h5 mb-20">Editar su perfil</h4>

                                                                @if ($paciente)
                                                                <div class="form-group">
                                                                    <label>Nombre</label>
                                                                    <input id="name" name="name" class="form-control form-control-lg" type="text" value="{{ $paciente->nombre }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Paterno</label>
                                                                    <input id="paterno" name="paterno" class="form-control form-control-lg" type="text" value="{{ $paciente->paterno }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Materno</label>
                                                                    <input id="materno" name="materno" class="form-control form-control-lg" type="text" value="{{ $paciente->materno }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Email</label>
                                                                    <input id="email" name="email" class="form-control form-control-lg" type="email" value="{{ $paciente->user->email }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Fecha de Nacimiento</label>
                                                                    <input id="fecha_nac" name="fecha_nac" class="form-control form-control-lg" type="date" value="{{ $paciente->fecha_nac ?? 'N/A' }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Celular</label>
                                                                    <input id="celular" name="celular" class="form-control form-control-lg" type="text" value="{{ $paciente->celular ?? 'N/A' }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Dirección</label>
                                                                    <textarea id="direccion" name="direccion" class="form-control">{{ $paciente->direccion ?? 'N/A' }}</textarea>
                                                                </div>
                                                                @else
                                                                <div class="form-group">
                                                                    <label>Nombre</label>
                                                                    <input id="nameUser" name="nameUser" class="form-control form-control-lg" type="text" value="{{ auth::user()->name }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Correo</label>
                                                                    <input id="emailUser" name="emailUser" class="form-control form-control-lg" type="email" value="{{ auth::user()->email }}">
                                                                </div>

                                                                @endif
                                                                <div class="form-group mb-0">
                                                                    <input type="submit" class="btn btn-primary" value="Actualizar Perfil">
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </form>

                                                </div>
                                            </div>
                                            <!-- Setting Tab End -->
                                            <div class="tab-pane fade" id="tasks" role="tabpanel">
                                                <div class="pd-20 profile-task-wrap">
                                                    <div class="container pd-0">

                                                        <div class="profile-task-list pb-30">
                                                            <!-- Sección de Mensajes -->

                                                            <div class="card card-body mx-3 mx-md-4 mt-n6">
                                                                <div class="row gx-4 mb-2">
                                                                    <div class="col-md-12">
                                                                        <h6>Todos los Mensajes</h6>
                                                                        <!-- Listado de mensajes -->
                                                                        @foreach ($mensajes as $mensaje)

                                                                        <div class="card mb-3">
                                                                            <div class="card-body">
                                                                                <h5 class="card-title">Nombre: {{ $mensaje->data }}</h5>
                                                                                <p class="card-text">Asunto: {{ $mensaje->asunto }}</p>
                                                                                <p class="card-text">Mensaje: {{ $mensaje->mensaje }}</p>
                                                                                <p class="card-text"><small
                                                                                        class="text-muted">{{ $mensaje->created_at->diffForHumans() }}</small>
                                                                                </p>
                                                                            </div>
                                                                        </div>


                                                                        @endforeach

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Fin de la sección de Mensajes -->
                                                        </div>
                                                    </div>
                                                    <!-- Open Task End -->

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        </div>
    </main>
</x-layout>