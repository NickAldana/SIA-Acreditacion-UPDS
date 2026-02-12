{{-- resources/views/partials/alerts.blade.php --}}

{{-- ALERTA DE ÉXITO --}}
@if(session('success'))
    <div class="alert bg-white border-start border-4 border-success shadow-sm rounded-3 mb-4 d-flex align-items-center p-3 animate__animated animate__fadeIn">
        <div class="rounded-circle bg-success bg-opacity-10 text-success p-2 me-3">
            <i class="bi bi-check-lg fs-4"></i>
        </div>
        <div>
            <h6 class="fw-bold text-dark mb-0">¡Excelente!</h6>
            <small class="text-muted">{{ session('success') }}</small>
        </div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- ALERTA DE ERROR GENERAL --}}
@if(session('error'))
    <div class="alert bg-white border-start border-4 border-danger shadow-sm rounded-3 mb-4 d-flex align-items-center p-3 animate__animated animate__shakeX">
        <div class="rounded-circle bg-danger bg-opacity-10 text-danger p-2 me-3">
            <i class="bi bi-x-circle-fill fs-4"></i>
        </div>
        <div>
            <h6 class="fw-bold text-danger mb-0">Ocurrió un error</h6>
            <small class="text-muted">{{ session('error') }}</small>
        </div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- ALERTA DE ERRORES DE VALIDACIÓN (Lista) --}}
@if ($errors->any())
    <div class="alert bg-white border-start border-4 border-danger shadow-sm rounded-3 mb-4 p-3 animate__animated animate__fadeIn">
        <div class="d-flex align-items-center mb-2">
            <div class="rounded-circle bg-danger bg-opacity-10 text-danger p-2 me-3">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            </div>
            <h6 class="fw-bold text-danger mb-0">Atención: Revisa los campos</h6>
        </div>
        <ul class="mb-0 small text-muted ps-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif