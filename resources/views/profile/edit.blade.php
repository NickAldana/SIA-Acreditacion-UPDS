@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="container py-4">

    {{-- ALERTAS --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-4 animate__animated animate__fadeIn">
            <i class="bi bi-check-circle-fill fs-4 me-3 text-success"></i>
            <div>
                <h6 class="fw-bold mb-0 text-success">¡Cambios Guardados!</h6>
                <small class="text-success">{{ session('success') }}</small>
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center mb-4 animate__animated animate__fadeIn">
            <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-danger"></i>
            <div>
                <h6 class="fw-bold mb-0 text-danger">Atención</h6>
                <small class="text-danger">Hay errores en el formulario.</small>
            </div>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    
                    {{-- 1. SECCIÓN TIPO "CV" (ENCABEZADO) --}}
                    <div class="card-body bg-white p-4 p-md-5">
                        
                        <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-4 mb-5 border-bottom pb-5">
                            
                            {{-- FOTO (Izquierda) --}}
                            <div class="position-relative flex-shrink-0">
                                <div class="avatar-container shadow-sm rounded-circle p-1 bg-white border">
                                    <img id="avatarPreview" 
                                         src="{{ $docente->Fotoperfil ? asset('storage/' . $docente->Fotoperfil) : 'https://ui-avatars.com/api/?name='.urlencode($docente->Nombrecompleto).'&background=003566&color=ffc300&size=256' }}" 
                                         class="rounded-circle object-cover" 
                                         width="140" height="140" 
                                         alt="Perfil">
                                </div>
                                {{-- Botón Cámara --}}
                                <label for="fotoInput" class="btn-camera shadow hover-scale" title="Cambiar Foto">
                                    <i class="bi bi-camera-fill"></i>
                                    <input type="file" name="Fotoperfil" id="fotoInput" class="d-none" accept="image/*">
                                </label>
                            </div>

                            {{-- DATOS (Derecha) --}}
                            <div class="flex-grow-1 text-center text-md-start pt-2">
                                <h2 class="fw-black text-upds-blue mb-1">
                                    {{ $docente->Nombrecompleto }} {{ $docente->Apellidopaterno }}
                                </h2>
                                <div class="mb-3">
                                    <span class="badge bg-upds-gold text-upds-blue fw-bold mb-2 me-1">
                                        {{ $docente->cargo->Nombrecargo ?? 'Docente' }}
                                    </span>
                                    <span class="badge bg-light text-muted border fw-normal">
                                        {{ $docente->contrato->Nombrecontrato ?? 'Contrato' }}
                                    </span>
                                </div>

                                {{-- Datos Institucionales (Solo Lectura) --}}
                                <div class="row g-2 justify-content-center justify-content-md-start">
                                    <div class="col-auto">
                                        <div class="d-flex align-items-center text-muted small bg-gray-50 px-3 py-2 rounded-pill border">
                                            <i class="bi bi-person-vcard fs-5 me-2 text-upds-blue"></i>
                                            <span class="fw-bold text-dark">{{ $docente->Ci }}</span>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="d-flex align-items-center text-muted small bg-gray-50 px-3 py-2 rounded-pill border">
                                            <i class="bi bi-envelope-at fs-5 me-2 text-upds-blue"></i>
                                            <span class="fw-bold text-dark">{{ $docente->Correoelectronico }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 2. FORMULARIO DE EDICIÓN (Debajo) --}}
                        <div class="row g-5">
                            
                            {{-- COLUMNA 1: CONTACTO --}}
                            <div class="col-md-5">
                                <h5 class="fw-bold text-upds-blue mb-4 border-bottom pb-2">
                                    <i class="bi bi-whatsapp me-2 text-success"></i> Contacto
                                </h5>
                                <div class="form-group">
                                    <label class="form-label fw-bold text-secondary small">Número Celular Actual</label>
                                    <input type="text" name="Telelefono" 
                                           class="form-control form-control-lg bg-gray-50 border-0 ps-3 @error('Telelefono') is-invalid @enderror" 
                                           value="{{ old('Telelefono', $docente->Telelefono) }}"
                                           placeholder="70012345">
                                    @error('Telelefono')
                                        <div class="text-danger small mt-1 fw-bold">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text mt-2 ms-1">
                                        <i class="bi bi-info-circle"></i> Visible para administración académica.
                                    </div>
                                </div>
                            </div>

                            {{-- COLUMNA 2: SEGURIDAD --}}
                            <div class="col-md-7 border-start-md ps-md-5">
                                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
                                    <h5 class="fw-bold text-upds-blue mb-0">
                                        <i class="bi bi-shield-lock me-2 text-warning"></i> Contraseña
                                    </h5>
                                    <span class="badge bg-light text-muted border fw-normal">Opcional</span>
                                </div>

                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="password" name="password" id="password" 
                                                   class="form-control bg-gray-50 border-0" 
                                                   placeholder="Nueva" autocomplete="new-password">
                                            <label class="text-muted">Nueva Contraseña</label>
                                        </div>
                                        @error('password')
                                            <div class="text-danger small fw-bold mt-1 ps-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                                   class="form-control bg-gray-50 border-0" 
                                                   placeholder="Confirmar">
                                            <label class="text-muted">Confirmar Contraseña</label>
                                        </div>
                                        <div id="match-message" class="small fw-bold mt-2 ps-1 d-none"></div>
                                    </div>
                                </div>

                                {{-- Requisitos (Pills) --}}
                                <div class="mt-3">
                                    <div class="d-flex flex-wrap gap-2" id="req-list">
                                        <span id="req-length" class="badge bg-white text-muted border fw-normal py-2 px-3"><i class="bi bi-circle me-1"></i> 8+ Caracteres</span>
                                        <span id="req-lower" class="badge bg-white text-muted border fw-normal py-2 px-3"><i class="bi bi-circle me-1"></i> Minúscula</span>
                                        <span id="req-upper" class="badge bg-white text-muted border fw-normal py-2 px-3"><i class="bi bi-circle me-1"></i> Mayúscula</span>
                                        <span id="req-number" class="badge bg-white text-muted border fw-normal py-2 px-3"><i class="bi bi-circle me-1"></i> Número</span>
                                        <span id="req-symbol" class="badge bg-white text-muted border fw-normal py-2 px-3"><i class="bi bi-circle me-1"></i> Símbolo</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- FOOTER --}}
                    <div class="card-footer bg-gray-50 border-top py-4 px-5 d-flex justify-content-end align-items-center gap-3">
                        <a href="{{ route('dashboard') }}" class="btn btn-link text-muted text-decoration-none fw-bold">Cancelar</a>
                        <button type="submit" class="btn btn-upds-primary btn-lg rounded-pill px-5 fw-bold shadow hover-scale">
                            <i class="bi bi-save2-fill me-2"></i> Guardar Cambios
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    :root {
        --upds-blue: #003566;
        --upds-gold: #ffc300;
        --gray-50: #f8fafc;
    }
    
    .text-upds-blue { color: var(--upds-blue) !important; }
    .bg-upds-gold { background-color: var(--upds-gold) !important; }
    .bg-gray-50 { background-color: var(--gray-50) !important; }
    
    .fw-black { font-weight: 900; }
    .object-cover { object-fit: cover; }

    /* Botón Cámara Flotante */
    .btn-camera {
        position: absolute; bottom: 5px; right: 0;
        width: 38px; height: 38px;
        background: var(--upds-gold); color: var(--upds-blue);
        border-radius: 50%; border: 3px solid white;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: transform 0.2s;
        z-index: 10;
    }
    .btn-camera:hover { transform: scale(1.1); }

    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(0, 53, 102, 0.1);
        background-color: white;
    }

    .btn-upds-primary {
        background-color: var(--upds-blue); color: white; border: none;
        transition: all 0.3s;
    }
    .btn-upds-primary:hover {
        background-color: #002342; transform: translateY(-2px);
    }
    
    .hover-scale:hover { transform: scale(1.02); transition: 0.2s; }

    @media (min-width: 768px) {
        .border-start-md { border-left: 1px solid #dee2e6; }
    }

    /* Badges */
    #req-list .badge { transition: all 0.3s ease; font-size: 0.75rem; }
    #req-list .badge.valid { background-color: #d1e7dd !important; color: #0f5132 !important; border-color: #badbcc !important; }
    #req-list .badge.invalid { background-color: #f8d7da !important; color: #842029 !important; border-color: #f5c2c7 !important; }
</style>
@endpush

@push('scripts')
<script>
    // Usamos una función autoejecutable para aislar el contexto
    (function() {
        document.addEventListener('DOMContentLoaded', function() {
            
            // ==========================================
            // 1. PREVISUALIZACIÓN DE FOTO (Lógica Robusta)
            // ==========================================
            const fotoInput = document.getElementById('fotoInput');
            const avatarPreview = document.getElementById('avatarPreview');

            // Debug: Verificamos si los elementos existen en la consola
            if (!fotoInput) console.error("❌ Error: No encuentro el input con id='fotoInput'");
            if (!avatarPreview) console.error("❌ Error: No encuentro la imagen con id='avatarPreview'");

            if (fotoInput && avatarPreview) {
                fotoInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    
                    if (file) {
                        // Validamos que sea imagen
                        if (!file.type.startsWith('image/')) {
                            alert('⚠️ El archivo seleccionado no es una imagen.');
                            return;
                        }

                        // Creamos el lector de archivos local
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            // ¡Aquí ocurre la magia visual!
                            avatarPreview.src = e.target.result;
                            console.log("✅ Imagen previsualizada correctamente");
                        }
                        
                        // Leemos el archivo
                        reader.readAsDataURL(file);
                    }
                });
            }

            // ==========================================
            // 2. VALIDACIÓN DE PASSWORD (Se mantiene igual)
            // ==========================================
            const passInput = document.getElementById('password');
            const confInput = document.getElementById('password_confirmation');
            const matchMsg = document.getElementById('match-message');

            const reqs = {
                length: document.getElementById('req-length'),
                lower: document.getElementById('req-lower'),
                upper: document.getElementById('req-upper'),
                number: document.getElementById('req-number'),
                symbol: document.getElementById('req-symbol')
            };

            const patterns = {
                lower: /[a-z]/,
                upper: /[A-Z]/,
                number: /[0-9]/,
                symbol: /[!@#$%^&*(),.?":{}|<>]/
            };

            function updateBadge(el, isValid) {
                if(!el) return;
                const icon = el.querySelector('i');
                if (isValid) {
                    el.classList.add('valid');
                    el.classList.remove('invalid', 'text-muted', 'bg-white');
                    if(icon) icon.className = 'bi bi-check-circle-fill me-1';
                } else {
                    if(passInput.value.length > 0) {
                        el.classList.add('invalid');
                        el.classList.remove('valid', 'text-muted', 'bg-white');
                        if(icon) icon.className = 'bi bi-x-circle me-1';
                    } else {
                        el.className = 'badge bg-white text-muted border fw-normal py-2 px-3 shadow-sm';
                        if(icon) icon.className = 'bi bi-circle me-1';
                    }
                }
            }

            if (passInput) {
                passInput.addEventListener('input', () => {
                    const val = passInput.value;
                    updateBadge(reqs.length, val.length >= 8);
                    updateBadge(reqs.lower, patterns.lower.test(val));
                    updateBadge(reqs.upper, patterns.upper.test(val));
                    updateBadge(reqs.number, patterns.number.test(val));
                    updateBadge(reqs.symbol, patterns.symbol.test(val));
                    checkMatch();
                });
            }

            if (confInput) confInput.addEventListener('input', checkMatch);

            function checkMatch() {
                if (!confInput.value) { 
                    if(matchMsg) matchMsg.classList.add('d-none'); return; 
                }
                if(matchMsg) matchMsg.classList.remove('d-none');
                
                if (passInput.value === confInput.value) {
                    if(matchMsg) matchMsg.innerHTML = '<span class="text-success"><i class="bi bi-check-all"></i> Coinciden</span>';
                } else {
                    if(matchMsg) matchMsg.innerHTML = '<span class="text-danger"><i class="bi bi-exclamation-circle"></i> No coinciden</span>';
                }
            }
        });
    })();
</script>
@endpush