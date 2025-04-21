<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="col-12">
                <div class="card my-4">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="pd-20 card-box mb-30">
                        <div class="clearfix text-center">
                            <h4 class="text-blue h4">
                                <img src="{{ asset('src/images/nutrilogo.png') }}" alt="Logo" style="max-width: 40px; margin-right: 10px;">
                                REALIZA TU CONSULTA
                            </h4>
                            <p class="mb-30">Contesta los siguientes campos para que tengas un diagnostico bien espefecifico para ti!</p>
                        </div>

         <div class="wizard-content">
                <form class="tab-wizard wizard-circle wizard" method="POST" action="{{route('registrar_adicional')}}">
                                @csrf
                                <input type="hidden" name="consulta_id" value="{{ request()->get('consulta_id') }}">

                                <!-- IMC Step -->
                                <h5 class="text-center">
                                    <img src="{{ asset('src/images/imc.png') }}" alt="Logo" style="max-width: 30px; margin-right: 10px;">
                                    IMC
                                </h5>
                             <section>
                                   <div class="row justify-content-center mt-5">
                                      <div class="col-md-5 d-flex align-items-center justify-content-center">
                                           <label for="peso" class="mr-3">
                                               <img src="{{ asset('src/images/balanza.png') }}" alt="Logo" style="max-width: 30px; margin-right: 10px;">
                                                    Peso (kg): 
                                            </label>
                                          <input name="peso" type="number" class="form-control text-center mb-3 rounded" id="peso" placeholder="¿cuanto pesas?" required style="max-width: 200px;">
                                     </div>
                                   </div>

                                   <div class="row justify-content-center mt-4">
                                       <div class="col-md-5 d-flex align-items-center justify-content-center">
                                           <label for="altura" class="mr-3">
                                              <img src="{{ asset('src/images/altura.png') }}" alt="Logo" style="max-width: 30px; margin-right: 10px;">
                                                 Altura (m):
                                          </label>
                                             <input name="altura" type="number" step="0.01" class="form-control text-center mb-3 rounded" id="altura" placeholder="¿cuanto mides?" required style="max-width: 200px;">
                                      </div>
                                  </div>
                             </section>



                               <!-- Condición Step -->
                                <h5 class="text-center mt-5">
                                   <img src="{{ asset('src/images/condicion.png') }}" alt="Logo" style="max-width: 30px; margin-right: 10px;">
                                     Condición:
                                </h5>
                            <section>
                                 <div class="row justify-content-center mt-4">
                                      <div class="col-md-5 d-flex align-items-center justify-content-center">
                                            <label for="operaciones" class="mr-3">
                                                    <img src="{{ asset('src/images/operaciones.png') }}" alt="Logo" style="max-width: 30px; margin-right: 10px;">
                                                 <i class="fas fa-syringe"></i> Operaciones:
                                           </label>
                                                <select name="operaciones" id="operaciones" class="form-control rounded" style="max-width: 200px;">
                                                    <option value="Ninguno">Ninguno</option>
                                                    <option value="Implante de cadera">Implante de cadera</option>
                                                    <option value="Implante de rodilla">Implante de rodilla</option>
                                                    <option value="Implante de columna">Implante de columna</option>
                                                    <option value="Implante de hombro">Implante de hombro</option>
                                                    <option value="Implante de muñeca">Implante de muñeca</option>
                                                </select>
                                        </div>
                                    </div>

                                    <div class="row justify-content-center mt-4">
                                       <div class="col-md-5 d-flex align-items-center justify-content-center">
                                             <label for="alergia" class="mr-3">
                                                    <img src="{{ asset('src/images/alergia.png') }}" alt="Logo" style="max-width: 30px; margin-right: 10px;">
                                                    <i class="fas fa-allergies"></i> Alergias:
                                              </label>
                                                      <input name="alergia" type="text" class="form-control rounded" id="alergia" placeholder="" style="max-width: 200px;">
                                         </div>
                                    </div>

                                   <div class="row justify-content-center mt-4">
                                      <div class="col-md-5 d-flex align-items-center justify-content-center">
                                            <label for="alergia" class="mr-3">
                                                <img src="{{ asset('src/images/discapacidad.png') }}" alt="Logo" style="max-width: 30px; margin-right: 10px;">
                                                Discapacidad:
                                            </label>
                                            <input name="discapacidad" type="text" class="form-control rounded" id="discapacidad" placeholder="" style="max-width: 200px;">
                                        </div>
                                    </div>

   
                            </section>
                                        <!-- Examen Step -->
                                        <h5 class="text-center mt-5">
                                            <img src="{{ asset('src/images/examen.png') }}" alt="Logo" style="max-width: 30px; margin-right: 10px;">
                                            Examen
                                        </h5>
                                        <section>
                                        <div class="row justify-content-center mt-4">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('src/images/tipoexamen.png') }}" alt="Logo" style="max-width: 30px; margin-right: 15px;">
                                                    <label for="examen" class="mb-0" style="font-weight: bold;">
                                                        <i class="fas fa-clipboard-list" style="margin-right: 8px;"></i>
                                                        Seleccione el tipo de examen que se realizo
                                                    </label>
                                                </div>
                                                <div class="mt-3">
                                                    <select name="examen" id="examen" class="custom-select2 form-control rounded" style="width: 100%; height: 80px;">
                                                        @foreach($tipoExamen as $tipo)
                                                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>



                          <div class="row justify-content-center mt-4">
                             <div class="col-md-5 d-flex align-items-center justify-content-center">
                             <label for="descripcion" class="mr-3">
                              <img src="{{ asset('src/images/especifique.png') }}" alt="Logo" style="max-width: 30px; margin-right: 10px;">
                              <i class="fas fa-pencil-alt"></i> Especifique
                                         </label>
                             <input name="descripcion" type="text" class="form-control rounded" id="descripcion" placeholder="Especifique el examen" style="max-width: 300px;">
                           </div>
                          </div>
                            </section>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
       
    </main>
</x-layout>