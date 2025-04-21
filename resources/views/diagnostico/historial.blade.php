<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <head>
        <!-- CSS para DataTables -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
        <!-- JS para DataTables -->
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
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
                    <div class="card-box mb-30">
                        <div class="pd-20">
                            <h4 class="text-blue h4">Historial</h4>
                        </div>
                        <div class="pb-20">
                            <table class="table hover multiple-select-row data-table-exports nowrap">
                                <thead>
                                    <tr>
                                        <th >Objetivo</th>
                                        <th >Motivo</th>
                                        <th >Peso</th>
                                        <th >fecha diagnostico</th>
                                        <th >Accion</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($diagnosticos as $diagnostico)
                                    <tr>

                                        <td class="table-plus">{{ $diagnostico->consulta->motivo }}</td>
                                        <td class="table-plus">{{ $diagnostico->consulta->objetivo }}</td>
                                        <td class="table-plus">{{ optional($diagnostico->consulta->imc)->peso ?? 'N/A' }}</td>

                                        <td class="table-plus">{{ $diagnostico->created_at->format('d-m-Y') }}</td>
                                        <td class="align-middle text-center">
                                            <a href="{{ route('detalle_historial', $diagnostico->id) }}" class="btn btn-success">Ver Detalles</a>
                                            <!-- Otras acciones como editar o eliminar si es necesario -->
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="{{ route('plan_nutriHistorial', $diagnostico->id) }}" class="btn btn-success">Ver Plan</a>
                                            <!-- Otras acciones como editar o eliminar si es necesario -->
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No hay Historial.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <script>
                                $(document).ready(function() {
                                    $('.data-table-exports').DataTable({
                                        // Configuración adicional si es necesario
                                        responsive: true,
                                        dom: 'Bfrtip', // Necesario para exportar
                                        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'] // Opciones de exportación
                                    });
                                });
                            </script>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        </div>
    </main>
</x-layout>