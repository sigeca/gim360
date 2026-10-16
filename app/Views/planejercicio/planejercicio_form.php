<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-card-checklist text-info me-2"></i>Nuevo Plan de Ejercicio</h2>
                <p class="text-muted mb-0">Registrar un nuevo plan de ejercicio en <code>planejercicio</code>.</p>
            </div>
            <a href="<?= base_url('planejercicio/elprimero') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver a Registro
            </a>
        </div>

        <div class="card card-custom bg-white border-top border-4 border-info shadow-sm">
            <div class="card-body p-4">
                <form action="<?= base_url('planejercicio/save') ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- 1. Nombre del Plan de Ejercicio -->
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-semibold">
                            <i class="bi bi-tag text-info me-1"></i>Nombre del Plan de Ejercicio <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nombre" id="nombre" class="form-control" maxlength="100" placeholder="Ej. Hipertrofia Pectoral 4x12, Fuerza Básica Pierna..." value="<?= esc(old('nombre')) ?>" required autofocus>
                        <div class="form-text">Nombre descriptivo para identificar este plan de ejercicio (máx. 100 caracteres).</div>
                    </div>

                    <!-- 2. Ejercicio Asignado con Visualizador de Imagen -->
                    <div class="mb-4">
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-1 gap-2">
                            <label for="idejercicio" class="form-label fw-semibold mb-0">
                                <i class="bi bi-fire text-danger me-1"></i>Ejercicio Asignado <span class="text-danger">*</span>
                            </label>
                            <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalCatalogoEjercicios">
                                <i class="bi bi-grid-3x3-gap-fill me-1"></i> Explorar Catálogo con Fotos
                            </button>
                        </div>

                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
                            <select name="idejercicio" id="idejercicio" class="form-select" required autofocus>
                                <option value="">-- Seleccione un Ejercicio del Catálogo --</option>
                                <?php foreach ($ejercicios as $e): ?>
                                    <?php
                                        $faseLabel = '';
                                        $faseType = 'general';
                                        if (!empty($e['imagen'])) {
                                            if (str_contains($e['imagen'], '-start.webp')) {
                                                $faseLabel = ' [Fase Inicial / Start]';
                                                $faseType = 'start';
                                            } elseif (str_contains($e['imagen'], '-peak.webp')) {
                                                $faseLabel = ' [Fase Final / Peak]';
                                                $faseType = 'peak';
                                            }
                                        }
                                    ?>
                                    <option value="<?= $e['idejercicio'] ?>"
                                            data-nombre="<?= esc($e['nombre']) ?>"
                                            data-imagen="<?= esc($e['imagen'] ?? '') ?>"
                                            data-fase="<?= $faseType ?>"
                                            data-descripcion="<?= esc(mb_strimwidth($e['descripcion'] ?? '', 0, 180, '...')) ?>"
                                            data-urlvideo="<?= esc($e['urlvideo'] ?? '') ?>"
                                            <?= old('idejercicio', $idejercicioPreselected ?? '') == $e['idejercicio'] ? 'selected' : '' ?>>
                                        <?= esc($e['nombre']) ?><?= $faseLabel ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button class="btn btn-outline-secondary" type="button" id="btnLimpiarEjercicio" title="Limpiar selección">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <div class="form-text">Ejercicio específico que se ejecutará en este plan. Seleccione del menú o use el catálogo visual con fotos para elegir el correcto.</div>

                        <!-- Estado vacío: aviso mientras no hay ejercicio seleccionado -->
                        <div id="ejercicioPreviewEmpty" class="card border border-dashed rounded-3 p-3 text-center text-muted bg-light-subtle mt-3">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-image fs-4 text-secondary opacity-75"></i>
                                <span class="small">Selecciona un ejercicio para previsualizar aquí su fotografía, técnica y detalles antes de guardar.</span>
                            </div>
                        </div>

                        <!-- Tarjeta de Previsualización Dinámica con Fotografía -->
                        <div id="ejercicioPreviewCard" class="card border border-info-subtle rounded-3 mt-3 shadow-sm overflow-hidden" style="display: none; background: #ffffff;">
                            <div class="card-header bg-light py-2 px-3 d-flex justify-content-between align-items-center border-bottom">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-dark" id="previewBadgeId">#ID</span>
                                    <span id="previewBadgeFase" class="badge bg-primary">Fase Inicial</span>
                                    <span id="previewBadgeVideo" class="badge bg-danger" style="display: none;"><i class="bi bi-youtube me-1"></i>Video Tutorial</span>
                                </div>
                                <a id="previewLinkFicha" href="#" target="_blank" class="btn btn-outline-secondary btn-sm py-0 px-2" style="font-size: 0.78rem;">
                                    <i class="bi bi-box-arrow-up-right me-1"></i>Ver Ficha
                                </a>
                            </div>
                            <div class="card-body p-3">
                                <div class="row g-3 align-items-center">
                                    <!-- Imagen -->
                                    <div class="col-sm-4 text-center">
                                        <div class="position-relative p-2 bg-light rounded border d-flex align-items-center justify-content-center" style="height: 160px; background-color: #ffffff;">
                                            <img id="previewImg" src="" alt="Ejercicio" class="img-fluid rounded" style="max-height: 145px; max-width: 100%; object-fit: contain; cursor: pointer;" title="Clic para ampliar imagen">
                                            <div id="previewNoImg" class="text-muted text-center py-3" style="display: none;">
                                                <i class="bi bi-image text-secondary opacity-50 display-6 d-block mb-1"></i>
                                                <span class="small fst-italic">Sin imagen asignada</span>
                                            </div>
                                        </div>
                                        <button type="button" id="btnZoomPreview" class="btn btn-link btn-sm text-decoration-none text-muted p-0 mt-1 small" style="font-size: 0.75rem;">
                                            <i class="bi bi-arrows-fullscreen me-1"></i>Ampliar foto
                                        </button>
                                    </div>
                                    <!-- Datos Técnicos -->
                                    <div class="col-sm-8">
                                        <h5 id="previewTitle" class="fw-bold text-dark mb-1 fs-6"></h5>
                                        <div class="small text-muted mb-2 font-monospace" style="font-size: 0.75rem;">
                                            <i class="bi bi-file-earmark-image me-1"></i><span id="previewFilename"></span>
                                        </div>
                                        <p id="previewDesc" class="text-secondary small mb-2" style="line-height: 1.4; max-height: 4.2em; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;"></p>
                                        <div class="d-flex align-items-center gap-2 pt-1 border-top">
                                            <small class="text-success fw-semibold"><i class="bi bi-check2-circle me-1"></i>Ejercicio seleccionado correctamente</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- 2. Días y Repeticiones -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="diassemanas" class="form-label fw-semibold">
                                <i class="bi bi-calendar3 text-primary me-1"></i>Días por Semana
                            </label>
                            <input type="number" name="diassemanas" id="diassemanas" class="form-control" min="1" step="1" placeholder="Ej. 3" value="<?= esc(old('diassemanas', old('dias'))) ?>">
                            <div class="form-text">Días de entrenamiento por semana (entero).</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="repeticiones" class="form-label fw-semibold">
                                <i class="bi bi-repeat text-success me-1"></i>Repeticiones por Serie
                            </label>
                            <input type="number" name="repeticiones" id="repeticiones" class="form-control" min="1" step="1" placeholder="Ej. 12" value="<?= esc(old('repeticiones')) ?>">
                            <div class="form-text">Número de repeticiones (entero).</div>
                        </div>
                    </div>

                    <!-- 3. Series, Descanso y Peso -->
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="series" class="form-label fw-semibold">
                                <i class="bi bi-layers text-secondary me-1"></i>Series
                            </label>
                            <input type="number" name="series" id="series" class="form-control" min="1" step="1" placeholder="Ej. 4" value="<?= esc(old('series')) ?>">
                            <div class="form-text">Número de series (entero).</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tiempodescanso" class="form-label fw-semibold">
                                <i class="bi bi-stopwatch text-warning me-1"></i>Tiempo Descanso (seg)
                            </label>
                            <input type="number" name="tiempodescanso" id="tiempodescanso" class="form-control" min="0" step="1" placeholder="Ej. 60 o 90" value="<?= esc(old('tiempodescanso')) ?>">
                            <div class="form-text">Descanso en segundos (entero).</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="peso" class="form-label fw-semibold">
                                <i class="bi bi-speedometer2 text-danger me-1"></i>Peso (kg)
                            </label>
                            <input type="number" name="peso" id="peso" class="form-control" min="0" step="0.25" placeholder="Ej. 50.00" value="<?= esc(old('peso')) ?>">
                            <div class="form-text">Carga/peso en kg (decimal).</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('planejercicio/elprimero') ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-info text-white fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Guardar Plan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Explorar Catálogo Visual de Ejercicios -->
<div class="modal fade" id="modalCatalogoEjercicios" tabindex="-1" aria-labelledby="modalCatalogoEjerciciosLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <div>
                    <h5 class="modal-title fw-bold" id="modalCatalogoEjerciciosLabel">
                        <i class="bi bi-images text-info me-2"></i>Catálogo Visual de Ejercicios
                    </h5>
                    <p class="text-muted small mb-0">Seleccione el ejercicio viendo su imagen y fase para asegurar la asignación correcta al plan.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-3">
                <!-- Filtros del Modal -->
                <div class="row g-2 mb-3 align-items-center">
                    <div class="col-md-7">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" id="modalSearchInput" class="form-control" placeholder="Buscar ejercicio por nombre o archivo (ej. sentadilla, bench press, bíceps)...">
                            <button class="btn btn-outline-secondary" type="button" id="btnModalClearSearch" title="Limpiar"><i class="bi bi-x-lg"></i></button>
                        </div>
                    </div>
                    <div class="col-md-5 d-flex gap-1 justify-content-md-end flex-wrap" id="filterPillsContainer">
                        <button type="button" class="btn btn-sm btn-outline-primary active filter-fase-btn" data-fase="all">Todos</button>
                        <button type="button" class="btn btn-sm btn-outline-primary filter-fase-btn" data-fase="start">Fase Inicial</button>
                        <button type="button" class="btn btn-sm btn-outline-success filter-fase-btn" data-fase="peak">Fase Final</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary filter-fase-btn" data-fase="with-image">Con Imagen</button>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-2 px-1">
                    <small class="text-muted" id="modalCountText">Cargando catálogo...</small>
                </div>

                <!-- Grid de Tarjetas de Ejercicios -->
                <div class="row g-3" id="modalEjerciciosGrid" style="min-height: 280px;">
                    <!-- Se llena dinámicamente con JavaScript -->
                </div>

                <!-- Botón Cargar Más si hay muchos resultados -->
                <div class="text-center mt-3" id="modalLoadMoreContainer" style="display: none;">
                    <button type="button" id="btnModalLoadMore" class="btn btn-outline-info btn-sm px-4">
                        <i class="bi bi-arrow-down-circle me-1"></i> Cargar más ejercicios
                    </button>
                </div>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Ampliar Imagen (Zoom) -->
<div class="modal fade" id="modalZoomImage" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0 shadow-none">
            <div class="modal-body p-0 text-center position-relative">
                <div class="bg-dark bg-opacity-75 rounded-4 p-3 d-inline-block shadow-lg" style="max-width: 95%;">
                    <div class="d-flex justify-content-between align-items-center text-white mb-2 px-2">
                        <span id="zoomModalTitle" class="fw-bold"></span>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <img id="zoomModalImg" src="" alt="Ejercicio Ampliado" class="img-fluid rounded-3 bg-white p-2" style="max-height: 70vh; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.exercise-card {
    transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease;
}
.exercise-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.1) !important;
    border-color: #0dcaf0 !important;
}
.exercise-card.selected-active {
    border: 2px solid #0dcaf0 !important;
    background-color: #f0fdfa !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('idejercicio');
    const emptyBox = document.getElementById('ejercicioPreviewEmpty');
    const card = document.getElementById('ejercicioPreviewCard');
    const img = document.getElementById('previewImg');
    const noImg = document.getElementById('previewNoImg');
    const title = document.getElementById('previewTitle');
    const badgeId = document.getElementById('previewBadgeId');
    const badgeFase = document.getElementById('previewBadgeFase');
    const badgeVideo = document.getElementById('previewBadgeVideo');
    const filename = document.getElementById('previewFilename');
    const desc = document.getElementById('previewDesc');
    const linkFicha = document.getElementById('previewLinkFicha');
    const btnZoomPreview = document.getElementById('btnZoomPreview');
    const btnLimpiar = document.getElementById('btnLimpiarEjercicio');

    const imgBaseUrl = '<?= base_url('ejercicio/imagen') ?>/';
    const fallbackImgUrl = '<?= base_url('repositorio/ejercicios/repdb-free/images/flat') ?>/';
    const recordBaseUrl = '<?= base_url('ejercicio/actual') ?>/';

    // Colección de ejercicios para el catálogo visual
    const catalogoEjercicios = <?= json_encode(array_map(function($e) {
        $fase = 'general';
        if (!empty($e['imagen'])) {
            if (str_contains($e['imagen'], '-start.webp')) $fase = 'start';
            elseif (str_contains($e['imagen'], '-peak.webp')) $fase = 'peak';
        }
        return [
            'id'     => (int)$e['idejercicio'],
            'nombre' => $e['nombre'],
            'imagen' => $e['imagen'] ?? '',
            'fase'   => $fase,
            'desc'   => mb_strimwidth($e['descripcion'] ?? '', 0, 100, '...'),
            'video'  => !empty($e['urlvideo']) ? 1 : 0
        ];
    }, $ejercicios), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;

    // Actualizar la previsualización del ejercicio asignado
    function updateEjercicioPreview() {
        const selected = select.options[select.selectedIndex];
        if (!selected || !selected.value) {
            if (emptyBox) emptyBox.style.display = 'block';
            if (card) card.style.display = 'none';
            return;
        }

        const id = selected.value;
        const nombre = selected.getAttribute('data-nombre') || selected.textContent.trim();
        const imagen = selected.getAttribute('data-imagen') || '';
        const descripcion = selected.getAttribute('data-descripcion') || '';
        const urlvideo = selected.getAttribute('data-urlvideo') || '';

        if (emptyBox) emptyBox.style.display = 'none';
        if (card) card.style.display = 'block';

        const inputNombre = document.getElementById('nombre');
        if (inputNombre && !inputNombre.value.trim() && nombre) {
            inputNombre.value = 'Plan ' + nombre;
        }

        if (badgeId) badgeId.textContent = '#' + id;
        if (title) title.textContent = nombre;
        if (linkFicha) linkFicha.href = recordBaseUrl + id;
        if (filename) filename.textContent = imagen ? imagen : 'Sin archivo asignado';
        if (desc) desc.textContent = descripcion ? descripcion : 'Sin descripción técnica detallada registrada.';

        // Badge de Video
        if (badgeVideo) {
            badgeVideo.style.display = urlvideo ? 'inline-block' : 'none';
        }

        // Badge de Fase
        if (badgeFase) {
            if (imagen.includes('-start.webp')) {
                badgeFase.textContent = 'Fase Inicial (Start)';
                badgeFase.className = 'badge bg-primary text-white';
                badgeFase.style.display = 'inline-block';
            } else if (imagen.includes('-peak.webp')) {
                badgeFase.textContent = 'Fase Final (Peak)';
                badgeFase.className = 'badge bg-success text-white';
                badgeFase.style.display = 'inline-block';
            } else if (imagen) {
                badgeFase.textContent = 'Ilustración General';
                badgeFase.className = 'badge bg-info-subtle text-info-emphasis border border-info-subtle';
                badgeFase.style.display = 'inline-block';
            } else {
                badgeFase.style.display = 'none';
            }
        }

        // Carga de Imagen con Fallback
        if (imagen) {
            img.onerror = function() {
                this.onerror = function() {
                    this.style.display = 'none';
                    if (noImg) noImg.style.display = 'block';
                };
                this.src = fallbackImgUrl + encodeURIComponent(imagen);
            };
            img.src = imgBaseUrl + encodeURIComponent(imagen);
            img.style.display = 'block';
            if (noImg) noImg.style.display = 'none';
            if (btnZoomPreview) btnZoomPreview.style.display = 'inline-block';
        } else {
            img.style.display = 'none';
            if (noImg) noImg.style.display = 'block';
            if (btnZoomPreview) btnZoomPreview.style.display = 'none';
        }
    }

    // Modal de Zoom de Imagen
    function openZoomModal(imgSrc, imgTitle) {
        const zoomImg = document.getElementById('zoomModalImg');
        const zoomTitle = document.getElementById('zoomModalTitle');
        if (zoomImg && imgSrc) {
            zoomImg.src = imgSrc;
            if (zoomTitle) zoomTitle.textContent = imgTitle || 'Previsualización del Ejercicio';
            const modalEl = document.getElementById('modalZoomImage');
            if (modalEl) {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        }
    }

    if (img) {
        img.addEventListener('click', function() {
            if (img.src && img.style.display !== 'none') {
                openZoomModal(img.src, title ? title.textContent : '');
            }
        });
    }

    if (btnZoomPreview) {
        btnZoomPreview.addEventListener('click', function(e) {
            e.preventDefault();
            if (img.src && img.style.display !== 'none') {
                openZoomModal(img.src, title ? title.textContent : '');
            }
        });
    }

    // Limpiar selección
    if (btnLimpiar) {
        btnLimpiar.addEventListener('click', function() {
            select.value = '';
            updateEjercicioPreview();
            select.focus();
        });
    }

    select.addEventListener('change', updateEjercicioPreview);
    updateEjercicioPreview();

    // ==========================================
    // LÓGICA DEL MODAL DE CATÁLOGO VISUAL
    // ==========================================
    const modalGrid = document.getElementById('modalEjerciciosGrid');
    const modalSearch = document.getElementById('modalSearchInput');
    const modalClearBtn = document.getElementById('btnModalClearSearch');
    const modalCountText = document.getElementById('modalCountText');
    const filterPills = document.querySelectorAll('.filter-fase-btn');
    const loadMoreContainer = document.getElementById('modalLoadMoreContainer');
    const btnLoadMore = document.getElementById('btnModalLoadMore');

    let currentFiltered = catalogoEjercicios;
    let visibleCount = 0;
    const batchSize = 36;
    let activeFaseFilter = 'all';

    function applyCatalogFilters() {
        const query = (modalSearch ? modalSearch.value : '').toLowerCase().trim();

        currentFiltered = catalogoEjercicios.filter(item => {
            // Filtro por texto
            const matchesText = !query || 
                item.nombre.toLowerCase().includes(query) || 
                item.imagen.toLowerCase().includes(query) || 
                String(item.id) === query;

            if (!matchesText) return false;

            // Filtro por fase / imagen
            if (activeFaseFilter === 'start') return item.fase === 'start';
            if (activeFaseFilter === 'peak') return item.fase === 'peak';
            if (activeFaseFilter === 'with-image') return !!item.imagen;

            return true;
        });

        visibleCount = 0;
        modalGrid.innerHTML = '';
        renderNextBatch();
    }

    function renderNextBatch() {
        const nextBatch = currentFiltered.slice(visibleCount, visibleCount + batchSize);
        visibleCount += nextBatch.length;

        if (modalCountText) {
            modalCountText.innerHTML = `Mostrando <strong>${visibleCount}</strong> de <strong>${currentFiltered.length}</strong> ejercicios disponibles`;
        }

        if (currentFiltered.length === 0) {
            modalGrid.innerHTML = `
                <div class="col-12 text-center py-5">
                    <i class="bi bi-search text-muted display-5 d-block mb-2"></i>
                    <h6 class="fw-bold text-dark">No se encontraron ejercicios</h6>
                    <p class="text-muted small">Intente buscar con otro término o retire los filtros activos.</p>
                </div>
            `;
            loadMoreContainer.style.display = 'none';
            return;
        }

        const currentSelectedId = select.value;

        nextBatch.forEach(item => {
            const col = document.createElement('div');
            col.className = 'col-6 col-md-4 col-lg-3';

            let faseBadge = '';
            if (item.fase === 'start') {
                faseBadge = '<span class="badge bg-primary position-absolute top-0 start-0 m-2" style="font-size:0.68rem;">Inicial</span>';
            } else if (item.fase === 'peak') {
                faseBadge = '<span class="badge bg-success position-absolute top-0 start-0 m-2" style="font-size:0.68rem;">Final</span>';
            }

            const isSelected = String(item.id) === String(currentSelectedId);
            const imgSrc = item.imagen ? (imgBaseUrl + encodeURIComponent(item.imagen)) : '';

            col.innerHTML = `
                <div class="card h-100 bg-white border shadow-sm rounded-3 overflow-hidden exercise-card ${isSelected ? 'selected-active' : ''}">
                    <div class="position-relative bg-light p-2 d-flex align-items-center justify-content-center" style="height: 130px; background-color: #f8fafc;">
                        ${faseBadge}
                        <span class="badge bg-dark bg-opacity-75 position-absolute top-0 end-0 m-2" style="font-size:0.68rem;">#${item.id}</span>
                        ${item.imagen ? `
                            <img src="${imgSrc}" 
                                 onerror="this.onerror=null; this.src='${fallbackImgUrl + encodeURIComponent(item.imagen)}';" 
                                 alt="${item.nombre}" 
                                 class="img-fluid rounded" 
                                 loading="lazy"
                                 style="max-height: 115px; max-width: 100%; object-fit: contain;">
                        ` : `
                            <div class="text-center text-muted">
                                <i class="bi bi-image opacity-50 fs-2 d-block"></i>
                                <span style="font-size:0.7rem;">Sin foto</span>
                            </div>
                        `}
                    </div>
                    <div class="card-body p-2 d-flex flex-column justify-content-between">
                        <div>
                            <div class="fw-bold text-dark text-truncate" title="${item.nombre}" style="font-size: 0.85rem;">
                                ${item.nombre}
                            </div>
                            <small class="text-muted d-block text-truncate font-monospace" style="font-size: 0.72rem;">
                                ${item.imagen ? item.imagen : 'Sin archivo'}
                            </small>
                        </div>
                        <button type="button" class="btn btn-sm ${isSelected ? 'btn-success' : 'btn-outline-info'} w-100 mt-2 py-1 select-exercise-btn" data-id="${item.id}" style="font-size: 0.8rem;">
                            <i class="bi ${isSelected ? 'bi-check2-circle' : 'bi-check-lg'} me-1"></i>${isSelected ? 'Seleccionado' : 'Seleccionar'}
                        </button>
                    </div>
                </div>
            `;
            modalGrid.appendChild(col);
        });

        // Mostrar u ocultar botón de cargar más
        if (visibleCount < currentFiltered.length) {
            loadMoreContainer.style.display = 'block';
        } else {
            loadMoreContainer.style.display = 'none';
        }
    }

    // Delegación de clic para seleccionar ejercicio dentro del modal
    modalGrid.addEventListener('click', function(e) {
        const btn = e.target.closest('.select-exercise-btn');
        if (btn) {
            const exerciseId = btn.getAttribute('data-id');
            select.value = exerciseId;
            updateEjercicioPreview();

            // Cerrar modal
            const modalEl = document.getElementById('modalCatalogoEjercicios');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) {
                modalInstance.hide();
            }

            // Efecto visual en la tarjeta de previsualización
            card.scrollIntoView({ behavior: 'smooth', block: 'center' });
            card.classList.add('border-info');
        }
    });

    if (btnLoadMore) {
        btnLoadMore.addEventListener('click', renderNextBatch);
    }

    if (modalSearch) {
        modalSearch.addEventListener('input', applyCatalogFilters);
    }

    if (modalClearBtn) {
        modalClearBtn.addEventListener('click', function() {
            if (modalSearch) {
                modalSearch.value = '';
                applyCatalogFilters();
                modalSearch.focus();
            }
        });
    }

    filterPills.forEach(pill => {
        pill.addEventListener('click', function() {
            filterPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            activeFaseFilter = this.getAttribute('data-fase');
            applyCatalogFilters();
        });
    });

    // Inicializar catálogo al abrir modal por primera vez
    const modalEl = document.getElementById('modalCatalogoEjercicios');
    if (modalEl) {
        modalEl.addEventListener('show.bs.modal', function() {
            applyCatalogFilters();
        });
    }
});
</script>

<?= $this->endSection() ?>
