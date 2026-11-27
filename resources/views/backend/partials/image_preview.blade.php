@php
    $imgFile = $file ?? null;
    $imgUrl = $imgFile ? berkas($imgFile) : null;
@endphp

@if(!empty($imgFile))
    <div class="d-flex flex-column" style="gap: 8px;">
        @if($imgUrl)
            <div>
                <a href="{{ $imgUrl }}" target="_blank" title="Klik untuk melihat ukuran penuh">
                    <img src="{{ $imgUrl }}"
                         alt="{{ $alt ?? $imgFile }}"
                         class="img-fluid rounded border shadow-sm"
                         style="max-height: {{ $maxHeight ?? '240px' }}; max-width: 100%; object-fit: contain; background: #f8fafc; padding: 4px;">
                </a>
            </div>
            <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                <span class="text-muted tx-12"><code>{{ $imgFile }}</code></span>
                <a href="{{ $imgUrl }}" target="_blank" class="btn btn-outline-primary btn-xs py-1 px-2">
                    <i class="fa fa-external-link"></i> Buka Ukuran Penuh
                </a>
            </div>
        @else
            <div class="alert alert-warning py-2 px-3 mb-0 tx-12">
                <i class="fa fa-exclamation-triangle"></i> File <code>{{ $imgFile }}</code> tercatat di database, namun file fisiknya tidak ditemukan di server.
            </div>
        @endif
    </div>
@else
    <span class="text-muted font-italic tx-12">Belum ada gambar.</span>
@endif
