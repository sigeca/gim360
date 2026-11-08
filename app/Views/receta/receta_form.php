<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card card-custom bg-white shadow-sm border-top border-4 border-warning mb-4">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                    <i class="bi bi-plus-circle-fill text-warning me-2"></i>Registrar Receta con Análisis Nutricional IA
                </h5>
                <a href="<?= base_url('receta/listar') ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Volver a la Lista
                </a>
            </div>
            <div class="card-body p-4">

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Por favor corrige los siguientes errores:</strong>
                        <ul class="mb-0 mt-2">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- SECCIÓN ASISTENTE INTELIGENTE GEMINI VISION -->
                <div class="card border border-warning bg-warning bg-opacity-10 mb-4 shadow-sm">
                    <div class="card-header bg-warning bg-opacity-25 py-2 px-3 d-flex justify-content-between align-items-center border-bottom border-warning">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-robot text-dark fs-5"></i>
                            <span class="fw-bold text-dark">Asistente IA - Reconocimiento de Platillos & Componentes</span>
                        </div>
                        <span class="badge bg-dark text-warning border border-warning">
                            <i class="bi bi-stars me-1"></i>Gemini Vision API
                        </span>
                    </div>
                    <div class="card-body p-3">
                        <p class="text-secondary small mb-3">
                            <i class="bi bi-info-circle-fill text-warning me-1"></i>
                            Toma una fotografía de tu platillo o sube una imagen de tu galería. Nuestra inteligencia artificial <strong>Gemini Vision</strong> identificará el plato, estimará porciones, tiempo de preparación, modo de elaboración y <strong>extraerá automáticamente sus componentes nutricionales</strong> para asociarlos y grabarlos con la receta.
                        </p>

                        <div class="row g-3 align-items-center">
                            <!-- Input de archivo / Cámara móvil -->
                            <div class="col-md-7">
                                <label for="foto" class="form-label small fw-bold text-dark mb-1">
                                    <i class="bi bi-camera-fill me-1 text-primary"></i>Seleccionar o Capturar Fotografía del Plato:
                                </label>
                                <div class="input-group">
                                    <input type="file" 
                                           class="form-control" 
                                           id="foto" 
                                           name="foto" 
                                           accept="image/*" 
                                           capture="environment">
                                    <button type="button" class="btn btn-outline-secondary" id="btn-abrir-webcam" title="Activar cámara web en vivo">
                                        <i class="bi bi-camera-video me-1"></i>Webcam
                                    </button>
                                </div>
                                <div class="form-text small text-muted">Formatos aceptados: JPG, PNG, WEBP (cámara móvil o archivo).</div>
                            </div>

                            <!-- Botón de Análisis con IA -->
                            <div class="col-md-5 d-flex flex-column justify-content-end">
                                <label class="form-label small fw-bold text-dark mb-1 d-none d-md-block">&nbsp;</label>
                                <button type="button" 
                                        id="btn-analizar-ia" 
                                        class="btn btn-warning text-dark fw-bold w-100 shadow-sm" 
                                        disabled>
                                    <i class="bi bi-stars me-1 text-danger"></i> Analizar Plato con IA
                                </button>
                            </div>
                        </div>

                        <!-- Vista previa de la fotografía -->
                        <div id="preview-container" class="mt-3 p-2 bg-white rounded border d-none">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="small fw-bold text-muted">
                                    <i class="bi bi-image me-1"></i>Vista Previa de la Fotografía:
                                </span>
                                <button type="button" class="btn btn-xs btn-outline-danger" id="btn-remover-foto" title="Remover fotografía">
                                    <i class="bi bi-trash me-1"></i>Quitar foto
                                </button>
                            </div>
                            <div class="text-center bg-light rounded py-2" style="max-height: 240px; overflow: hidden;">
                                <img id="img-preview" src="" alt="Vista previa del plato" class="img-fluid rounded shadow-sm" style="max-height: 220px; object-fit: contain;">
                            </div>
                        </div>

                        <!-- Indicador de carga durante análisis IA -->
                        <div id="ai-loading" class="mt-3 alert alert-info py-3 d-none align-items-center border-info">
                            <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                            <div>
                                <strong class="d-block text-primary">Analizando fotografía con Gemini Vision...</strong>
                                <span class="small text-muted">Identificando ingredientes, modo de preparación y extrayendo componentes nutricionales...</span>
                            </div>
                        </div>

                        <!-- Banner de resultado exitoso IA -->
                        <div id="ai-result-box" class="mt-3 alert alert-success py-2 d-none border-success">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <i class="bi bi-check-circle-fill text-success me-1"></i>
                                    <strong id="ai-result-title">¡Plato analizado con éxito!</strong>
                                    <span id="ai-result-msg" class="d-block small text-muted">Los datos del plato y sus componentes nutricionales han sido auto-completados.</span>
                                </div>
                                <span class="badge bg-success fs-6" id="ai-badge-count">0 componentes</span>
                            </div>
                            <div id="ai-ingredients-list" class="mt-2 pt-2 border-top border-success-subtle d-none">
                                <small class="fw-bold text-dark d-block mb-1"><i class="bi bi-basket me-1"></i>Ingredientes identificados por IA:</small>
                                <div id="ai-ingredients-tags" class="d-flex flex-wrap gap-1"></div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- FORMULARIO PRINCIPAL -->
                <form action="<?= base_url('receta/save') ?>" method="post" enctype="multipart/form-data" id="form-receta">
                    <?= csrf_field() ?>

                    <!-- Campo oculto para pasar la foto capturada por webcam si aplica -->
                    <input type="hidden" name="foto_base64_data" id="foto_base64_data" value="">

                    <!-- Nombre de la Receta -->
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-bold">
                            Nombre del Platillo / Receta <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-book-half text-warning"></i></span>
                            <input type="text" 
                                   class="form-control <?= session('errors.nombre') ? 'is-invalid' : '' ?>" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="<?= old('nombre') ?>" 
                                   placeholder="Ej: Salmón al Horno con Espárragos, Batido Proteico de Avena..." 
                                   maxlength="150" 
                                   required 
                                   autofocus>
                        </div>
                        <div class="form-text text-muted">Nombre distintivo del platillo o preparación culinaria.</div>
                    </div>

                    <!-- Porciones y Tiempo de Preparación -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="porciones" class="form-label fw-bold">
                                Porciones / Rendimiento
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-people-fill text-primary"></i></span>
                                <input type="number" 
                                       class="form-control <?= session('errors.porciones') ? 'is-invalid' : '' ?>" 
                                       id="porciones" 
                                       name="porciones" 
                                       value="<?= old('porciones', 1) ?>" 
                                       min="1" 
                                       max="99">
                                <span class="input-group-text small">personas</span>
                            </div>
                            <div class="form-text text-muted">Número de porciones que rinde la preparación.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="tiempopreparacion" class="form-label fw-bold">
                                Tiempo de Preparación
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-stopwatch text-danger"></i></span>
                                <input type="number" 
                                       class="form-control <?= session('errors.tiempopreparacion') ? 'is-invalid' : '' ?>" 
                                       id="tiempopreparacion" 
                                       name="tiempopreparacion" 
                                       value="<?= old('tiempopreparacion') ?>" 
                                       min="0" 
                                       placeholder="Ej: 25">
                                <span class="input-group-text small">minutos</span>
                            </div>
                            <div class="form-text text-muted">Tiempo estimado de elaboración en minutos.</div>
                        </div>
                    </div>

                    <!-- URL de Video Tutorial / Demostración en YouTube -->
                    <div class="mb-3">
                        <label for="video" class="form-label fw-bold">
                            URL de Video de Preparación (YouTube)
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-youtube text-danger"></i></span>
                            <input type="url" 
                                   class="form-control <?= session('errors.video') ? 'is-invalid' : '' ?>" 
                                   id="video" 
                                   name="video" 
                                   value="<?= old('video') ?>" 
                                   placeholder="https://www.youtube.com/watch?v=... o https://youtu.be/..." 
                                   maxlength="300">
                        </div>
                        <div class="form-text text-muted">Enlace opcional de YouTube con el video tutorial del paso a paso o preparación de la receta.</div>
                    </div>

                    <!-- Instrucciones -->
                    <div class="mb-4">
                        <label for="instrucciones" class="form-label fw-semibold">
                            Instrucciones / Modo de Preparación
                        </label>
                        <textarea name="instrucciones" 
                                  id="instrucciones" 
                                  rows="6" 
                                  class="form-control <?= session('errors.instrucciones') ? 'is-invalid' : '' ?>" 
                                  placeholder="Paso 1: Lavar y cortar los ingredientes...&#10;Paso 2: Cocinar a fuego medio...&#10;Paso 3: Servir templado..."><?= old('instrucciones') ?></textarea>
                        <div class="form-text text-muted">Describe detalladamente los pasos a seguir para elaborar la receta.</div>
                    </div>

                    <!-- SECCIÓN DE COMPONENTES NUTRICIONALES A GRABAR -->
                    <div class="card border border-info shadow-sm mb-4">
                        <div class="card-header bg-info bg-opacity-10 py-3 d-flex flex-wrap justify-content-between align-items-center gap-2 border-bottom border-info-subtle">
                            <div>
                                <h6 class="fw-bold mb-0 text-dark d-flex align-items-center">
                                    <i class="bi bi-pie-chart-fill text-info me-2 fs-5"></i>Componentes Nutricionales a Grabar
                                    <span class="badge bg-info text-white ms-2" id="contador-seleccionados">0 seleccionados</span>
                                </h6>
                                <small class="text-muted">Los componentes marcados se grabarán automáticamente en la base de datos vinculados a la receta.</small>
                            </div>
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-outline-info" id="btn-seleccionar-todos">Todos</button>
                                <button type="button" class="btn btn-outline-info" id="btn-deseleccionar-todos">Ninguno</button>
                                <button type="button" class="btn btn-info text-white" id="btn-solo-ia">
                                    <i class="bi bi-stars me-1"></i>Solo IA
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-2" id="contenedor-componentes">
                                <?php if (!empty($componentes)): ?>
                                    <?php foreach ($componentes as $comp): ?>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="form-check p-2 rounded border bg-light h-100 d-flex align-items-center comp-card transition-all" 
                                                 id="card-comp-<?= $comp['idcomponentenutricional'] ?>" 
                                                 style="cursor: pointer;">
                                                <input class="form-check-input ms-1 me-2 comp-checkbox" 
                                                       type="checkbox" 
                                                       name="componentes[]" 
                                                       value="<?= $comp['idcomponentenutricional'] ?>" 
                                                       id="comp_<?= $comp['idcomponentenutricional'] ?>"
                                                       data-nombre="<?= esc(mb_strtolower($comp['nombre'])) ?>">
                                                <label class="form-check-label fw-semibold text-dark small flex-grow-1" 
                                                       for="comp_<?= $comp['idcomponentenutricional'] ?>" 
                                                       style="cursor: pointer;">
                                                    <?= esc($comp['nombre']) ?>
                                                </label>
                                                <span class="badge bg-success text-white ms-auto d-none badge-ia" 
                                                      id="badge-ia-<?= $comp['idcomponentenutricional'] ?>" 
                                                      style="font-size: 0.65rem;">
                                                    <i class="bi bi-stars"></i> IA
                                                </span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-12 text-muted small text-center py-2">
                                        No se encontraron componentes nutricionales en el sistema.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('receta') ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-warning text-dark fw-bold px-4 shadow-sm" id="btn-submit-receta">
                            <i class="bi bi-check-circle-fill me-1"></i> Guardar Receta con Nutrientes
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<!-- Modal para captura por Webcam en Vivo -->
<div class="modal fade" id="modalWebcam" tabindex="-1" aria-labelledby="modalWebcamLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white py-3">
                <h6 class="modal-title fw-bold" id="modalWebcamLabel">
                    <i class="bi bi-camera-video-fill text-warning me-2"></i>Capturar Foto del Plato en Vivo
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" id="btn-cerrar-webcam"></button>
            </div>
            <div class="modal-body text-center p-3 bg-light">
                <div class="ratio ratio-4x3 bg-black rounded overflow-hidden shadow-sm mb-3">
                    <video id="webcam-video" autoplay playsinline class="w-100 h-100" style="object-fit: cover;"></video>
                </div>
                <canvas id="webcam-canvas" class="d-none"></canvas>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-warning text-dark fw-bold px-4" id="btn-capturar-foto">
                        <i class="bi bi-camera-fill me-1"></i> Capturar Fotografía
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.comp-card:hover {
    background-color: #f1f5f9 !important;
}
.comp-card.is-selected {
    background-color: #ecfeff !important;
    border-color: #06b6d4 !important;
}
.comp-card.is-ia-detected {
    background-color: #f0fdf4 !important;
    border-color: #22c55e !important;
    box-shadow: 0 0 0 1px #22c55e;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput         = document.getElementById('foto');
    const btnAnalizarIa     = document.getElementById('btn-analizar-ia');
    const previewContainer  = document.getElementById('preview-container');
    const imgPreview        = document.getElementById('img-preview');
    const btnRemoverFoto    = document.getElementById('btn-remover-foto');
    const aiLoading         = document.getElementById('ai-loading');
    const aiResultBox       = document.getElementById('ai-result-box');
    const aiResultTitle     = document.getElementById('ai-result-title');
    const aiResultMsg       = document.getElementById('ai-result-msg');
    const aiBadgeCount      = document.getElementById('ai-badge-count');
    const aiIngredientsList = document.getElementById('ai-ingredients-list');
    const aiIngredientsTags = document.getElementById('ai-ingredients-tags');
    const fotoBase64Data    = document.getElementById('foto_base64_data');

    // Inputs a autocompletar
    const inputNombre       = document.getElementById('nombre');
    const inputPorciones    = document.getElementById('porciones');
    const inputTiempo       = document.getElementById('tiempopreparacion');
    const inputInstrucciones= document.getElementById('instrucciones');

    // Checkboxes de componentes
    const checkboxes        = document.querySelectorAll('.comp-checkbox');
    const contadorSel       = document.getElementById('contador-seleccionados');
    const btnSelTodos       = document.getElementById('btn-seleccionar-todos');
    const btnDeselTodos     = document.getElementById('btn-deseleccionar-todos');
    const btnSoloIa         = document.getElementById('btn-solo-ia');

    // Webcam
    const btnAbrirWebcam    = document.getElementById('btn-abrir-webcam');
    const modalWebcamEl     = document.getElementById('modalWebcam');
    let modalWebcam         = null;
    if (modalWebcamEl && typeof bootstrap !== 'undefined') {
        modalWebcam = new bootstrap.Modal(modalWebcamEl);
    }
    const webcamVideo       = document.getElementById('webcam-video');
    const webcamCanvas      = document.getElementById('webcam-canvas');
    const btnCapturarFoto   = document.getElementById('btn-capturar-foto');
    const btnCerrarWebcam   = document.getElementById('btn-cerrar-webcam');
    let mediaStream         = null;

    let currentImageDataUrl = null;
    let iaDetectedIds       = [];

    // Actualiza contador y estilos visuales de los componentes
    function actualizarContadorComponentes() {
        let count = 0;
        checkboxes.forEach(cb => {
            const card = document.getElementById('card-comp-' + cb.value);
            if (cb.checked) {
                count++;
                if (card) card.classList.add('is-selected');
            } else {
                if (card) card.classList.remove('is-selected');
            }
        });
        contadorSel.textContent = count + ' seleccionado' + (count === 1 ? '' : 's');
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', actualizarContadorComponentes);
        const card = document.getElementById('card-comp-' + cb.value);
        if (card) {
            card.addEventListener('click', function (e) {
                if (e.target !== cb && e.target.tagName !== 'LABEL') {
                    cb.checked = !cb.checked;
                    cb.dispatchEvent(new Event('change'));
                }
            });
        }
    });

    btnSelTodos.addEventListener('click', function () {
        checkboxes.forEach(cb => { cb.checked = true; });
        actualizarContadorComponentes();
    });

    btnDeselTodos.addEventListener('click', function () {
        checkboxes.forEach(cb => { cb.checked = false; });
        actualizarContadorComponentes();
    });

    btnSoloIa.addEventListener('click', function () {
        checkboxes.forEach(cb => {
            cb.checked = iaDetectedIds.includes(parseInt(cb.value));
        });
        actualizarContadorComponentes();
    });

    // Manejo de archivo seleccionado
    fileInput.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            const reader = new FileReader();
            reader.onload = function (e) {
                currentImageDataUrl = e.target.result;
                imgPreview.src = currentImageDataUrl;
                previewContainer.classList.remove('d-none');
                btnAnalizarIa.disabled = false;
                fotoBase64Data.value = ''; // el archivo va por multipart
            };
            reader.readAsDataURL(file);
        }
    });

    btnRemoverFoto.addEventListener('click', function () {
        fileInput.value = '';
        currentImageDataUrl = null;
        imgPreview.src = '';
        previewContainer.classList.add('d-none');
        btnAnalizarIa.disabled = true;
        fotoBase64Data.value = '';
        aiResultBox.classList.add('d-none');
    });

    // Webcam en vivo
    btnAbrirWebcam.addEventListener('click', async function () {
        try {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                mediaStream = await navigator.mediaDevices.getUserMedia({
                    video: { facingMode: 'environment' },
                    audio: false
                });
                webcamVideo.srcObject = mediaStream;
                if (modalWebcam) modalWebcam.show();
            } else {
                alert('Tu navegador no soporta acceso directo a la cámara web. Utiliza el botón de seleccionar archivo.');
            }
        } catch (err) {
            alert('No se pudo acceder a la cámara: ' + err.message);
        }
    });

    function detenerWebcam() {
        if (mediaStream) {
            mediaStream.getTracks().forEach(t => t.stop());
            mediaStream = null;
        }
    }

    if (modalWebcamEl) {
        modalWebcamEl.addEventListener('hidden.bs.modal', detenerWebcam);
    }
    if (btnCerrarWebcam) {
        btnCerrarWebcam.addEventListener('click', detenerWebcam);
    }

    btnCapturarFoto.addEventListener('click', function () {
        if (!mediaStream) return;
        webcamCanvas.width = webcamVideo.videoWidth || 640;
        webcamCanvas.height = webcamVideo.videoHeight || 480;
        const ctx = webcamCanvas.getContext('2d');
        ctx.drawImage(webcamVideo, 0, 0, webcamCanvas.width, webcamCanvas.height);
        
        currentImageDataUrl = webcamCanvas.toDataURL('image/jpeg', 0.9);
        imgPreview.src = currentImageDataUrl;
        previewContainer.classList.remove('d-none');
        btnAnalizarIa.disabled = false;
        fotoBase64Data.value = currentImageDataUrl; // Pasarlo para envío en formulario

        detenerWebcam();
        if (modalWebcam) modalWebcam.hide();
    });

    // Disparar análisis con IA
    btnAnalizarIa.addEventListener('click', async function () {
        if (!currentImageDataUrl && (!fileInput.files || !fileInput.files[0])) {
            alert('Por favor selecciona o captura una foto del plato primero.');
            return;
        }

        btnAnalizarIa.disabled = true;
        aiLoading.classList.remove('d-none');
        aiResultBox.classList.add('d-none');

        const formData = new FormData();

        // Agregar CSRF si está presente
        const csrfTokenInput = document.querySelector('input[name="<?= csrf_token() ?>"]');
        if (csrfTokenInput) {
            formData.append('<?= csrf_token() ?>', csrfTokenInput.value);
        }

        if (fileInput.files && fileInput.files[0]) {
            formData.append('foto', fileInput.files[0]);
        } else if (currentImageDataUrl) {
            formData.append('foto_base64', currentImageDataUrl);
        }

        try {
            const endpoint = '<?= base_url('receta/analizar-foto') ?>';
            const response = await fetch(endpoint, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const res = await response.json();

            if (!res.success) {
                throw new Error(res.message || 'Error al analizar la imagen.');
            }

            const data = res.data;

            // 1. Autocompletar campos de texto de la receta
            if (data.nombre) inputNombre.value = data.nombre;
            if (data.porciones) inputPorciones.value = data.porciones;
            if (data.tiempopreparacion) inputTiempo.value = data.tiempopreparacion;
            if (data.instrucciones) inputInstrucciones.value = data.instrucciones;

            // 2. Extraer y marcar componentes nutricionales
            iaDetectedIds = data.matched_component_ids || [];
            
            // Limpiar badges IA previos
            document.querySelectorAll('.badge-ia').forEach(b => b.classList.add('d-none'));
            document.querySelectorAll('.comp-card').forEach(c => c.classList.remove('is-ia-detected'));

            iaDetectedIds.forEach(id => {
                const cb = document.getElementById('comp_' + id);
                if (cb) {
                    cb.checked = true;
                    const card = document.getElementById('card-comp-' + id);
                    if (card) card.classList.add('is-ia-detected');
                    const badge = document.getElementById('badge-ia-' + id);
                    if (badge) badge.classList.remove('d-none');
                }
            });

            actualizarContadorComponentes();

            // 3. Mostrar lista de ingredientes sugeridos
            if (data.ingredientes && Array.isArray(data.ingredientes) && data.ingredientes.length > 0) {
                aiIngredientsTags.innerHTML = '';
                data.ingredientes.forEach(ing => {
                    const tag = document.createElement('span');
                    tag.className = 'badge bg-light text-dark border';
                    tag.textContent = ing;
                    aiIngredientsTags.appendChild(tag);
                });
                aiIngredientsList.classList.remove('d-none');
            } else {
                aiIngredientsList.classList.add('d-none');
            }

            // 4. Mostrar feedback exitoso
            aiResultTitle.textContent = `¡Platillo "${data.nombre || 'Detectado'}" analizado con éxito!`;
            aiResultMsg.textContent = `Se detectaron ${iaDetectedIds.length} componentes nutricionales y se completaron los datos de la receta.`;
            aiBadgeCount.textContent = `${iaDetectedIds.length} nutriente${iaDetectedIds.length === 1 ? '' : 's'} detectado${iaDetectedIds.length === 1 ? '' : 's'}`;
            aiResultBox.classList.remove('d-none');

        } catch (err) {
            alert('Ocurrió un error al analizar la fotografía con la IA: ' + err.message);
        } finally {
            aiLoading.classList.add('d-none');
            btnAnalizarIa.disabled = false;
        }
    });

    // Inicializar contador al cargar la página
    actualizarContadorComponentes();
});
</script>

<?= $this->endSection() ?>
