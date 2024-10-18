<div class="card">
                    <div class="card-header text-center">
                        <h2>Contrato de Prestación de Servicios - FEL</h2>
                    </div>
                    <div class="card-body p-4">
                        <form>
                            <!-- Datos del Emisor -->
                            <h4 class="mb-3">Datos del Emisor</h4>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="nombreEmisor" class="form-label">Nombre:</label>
                                    <input type="text" class="form-control" id="nombreEmisor" placeholder="Ingresa el nombre del emisor">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="edadEmisor" class="form-label">Edad:</label>
                                    <input type="number" class="form-control" id="edadEmisor" placeholder="Ingresa la edad del emisor">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="dpiEmisor" class="form-label">DPI:</label>
                                    <input type="text" class="form-control" id="dpiEmisor" placeholder="Ingresa el DPI del emisor">
                                </div>
                            </div>

                            <div class="divider"></div>

                            <!-- Datos del Receptor -->
                            <h4 class="mb-3">Datos del Receptor</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombreReceptor" class="form-label">Nombre:</label>
                                    <input type="text" class="form-control" id="nombreReceptor" placeholder="Ingresa el nombre del receptor">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="edadReceptor" class="form-label">Edad:</label>
                                    <input type="number" class="form-control" id="edadReceptor" placeholder="Ingresa la edad">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="dpiReceptor" class="form-label">DPI:</label>
                                    <input type="text" class="form-control" id="dpiReceptor" placeholder="Ingresa el DPI">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="domicilioReceptor" class="form-label">Domicilio:</label>
                                    <input type="text" class="form-control" id="domicilioReceptor" placeholder="Ingresa el domicilio">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="departamentoEmision" class="form-label">Departamento de Emisión:</label>
                                    <input type="text" class="form-control" id="departamentoEmision" placeholder="Ingresa el departamento">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="municipioEmision" class="form-label">Municipio de Emisión:</label>
                                    <input type="text" class="form-control" id="municipioEmision" placeholder="Ingresa el municipio">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="nombreContratante" class="form-label">Nombre del Contratante:</label>
                                    <input type="text" class="form-control" id="nombreContratante" placeholder="Ingresa el nombre del contratante">
                                </div>
                            </div>

                            <div class="divider"></div>

                            <!-- Patente de Comercio -->
                            <h4 class="mb-3">Patente de Comercio</h4>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="fechaPatente" class="form-label">Fecha de Autorización:</label>
                                    <input type="date" class="form-control" id="fechaPatente">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="numeroInscripcion" class="form-label">Número de Inscripción:</label>
                                    <input type="text" class="form-control" id="numeroInscripcion" placeholder="Número de inscripción">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="folioRegistro" class="form-label">Folio:</label>
                                    <input type="text" class="form-control" id="folioRegistro" placeholder="Folio del registro">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="libroRegistro" class="form-label">Libro:</label>
                                    <input type="text" class="form-control" id="libroRegistro" placeholder="Libro del registro">
                                </div>
                            </div>

                            <div class="divider"></div>

                            <!-- Información Económica -->
                            <h4 class="mb-3">Información Económica</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="actividadEconomica" class="form-label">Actividad Económica:</label>
                                    <input type="text" class="form-control" id="actividadEconomica" placeholder="Actividad económica detallada">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="nit" class="form-label">NIT:</label>
                                    <input type="text" class="form-control" id="nit" placeholder="Ingresa el NIT">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="tarifaMensual" class="form-label">Tarifa Mensual:</label>
                                    <input type="number" class="form-control" id="tarifaMensual" placeholder="Tarifa mensual al certificador">
                                </div>
                            </div>

                            <div class="divider"></div>

                            <!-- Información del Contrato -->
                            <h4 class="mb-3">Información del Contrato</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cobroUnico" class="form-label">Cobro Único:</label>
                                    <input type="number" class="form-control" id="cobroUnico" placeholder="Cobro único">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fechaValidez" class="form-label">Fecha de Validez:</label>
                                    <input type="date" class="form-control" id="fechaValidez">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-4">Crear Contrato</button>
                        </form>
                    </div>
                </div>