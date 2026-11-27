@extends('layouts.backend')
@section('title', 'Optimasi Gambar & Konversi WebP')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item active">Optimasi Gambar &amp; Konversi WebP</span>
        </nav>
    </div>

    <div class="br-pagetitle">
        <i class="fas fa-images text-blue-600"></i>
        <div>
            <h4>Optimasi Gambar &amp; Konversi WebP</h4>
            <p class="mg-b-0">Konversi gambar ke format Next-Gen WebP secara bertahap tanpa membebani server.</p>
        </div>
    </div>

    <div class="br-pagebody font-sans space-y-6">
        {{-- 4 Stat Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="rounded-2xl bg-blue-600 text-white p-5 shadow-sm flex items-center justify-between">
                <div>
                    <div class="text-[11px] font-bold uppercase tracking-wider text-blue-100">Total Gambar</div>
                    <div id="stat-total" class="text-2xl font-black mt-1">-</div>
                    <div id="stat-size" class="text-xs text-blue-100 mt-0.5">-</div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-white/15 flex items-center justify-center text-xl">
                    <i class="fas fa-photo-film"></i>
                </div>
            </div>

            <div class="rounded-2xl bg-emerald-600 text-white p-5 shadow-sm flex items-center justify-between">
                <div>
                    <div class="text-[11px] font-bold uppercase tracking-wider text-emerald-100">Sudah WebP</div>
                    <div id="stat-webp" class="text-2xl font-black mt-1">-</div>
                    <div id="stat-webp-pct" class="text-xs text-emerald-100 mt-0.5">-</div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-white/15 flex items-center justify-center text-xl">
                    <i class="fas fa-circle-check"></i>
                </div>
            </div>

            <div class="rounded-2xl bg-amber-500 text-white p-5 shadow-sm flex items-center justify-between">
                <div>
                    <div class="text-[11px] font-bold uppercase tracking-wider text-amber-50">Perlu Optimasi</div>
                    <div id="stat-pending" class="text-2xl font-black mt-1">-</div>
                    <div class="text-xs text-amber-50 mt-0.5">Menunggu antrean</div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-white/15 flex items-center justify-center text-xl">
                    <i class="fas fa-clock"></i>
                </div>
            </div>

            <div class="rounded-2xl bg-teal-600 text-white p-5 shadow-sm flex items-center justify-between">
                <div>
                    <div class="text-[11px] font-bold uppercase tracking-wider text-teal-100">Potensi Hemat</div>
                    <div id="stat-save" class="text-2xl font-black mt-1">-</div>
                    <div class="text-xs text-teal-100 mt-0.5">Storage &amp; Bandwidth</div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-white/15 flex items-center justify-center text-xl">
                    <i class="fas fa-bolt"></i>
                </div>
            </div>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Left: Batch Optimization Control (8 cols) --}}
            <div class="lg:col-span-8">
                <div class="br-section-wrapper space-y-5">
                    <div class="flex flex-wrap items-center justify-between gap-3 pb-3 border-b border-slate-200">
                        <div>
                            <h5 class="text-sm font-extrabold uppercase tracking-wider text-slate-800 mb-0.5">
                                Kontrol Optimasi Bertahap
                            </h5>
                            <p class="text-xs text-slate-500 mb-0">
                                Mengonversi file tanpa downtime dengan batch slicing (5 - 30 foto per hit).
                            </p>
                        </div>
                        <span id="status-badge" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-cyan-50 text-cyan-700 border border-cyan-200">
                            <i class="fas fa-circle-info"></i> Siap dijalankan
                        </span>
                    </div>

                    {{-- Progress Bar --}}
                    <div>
                        <div class="flex items-center justify-between text-xs font-bold mb-1.5">
                            <span id="progress-label" class="text-emerald-700">Kemajuan Optimasi: 0%</span>
                            <span id="progress-count" class="text-slate-500">0 / 0 file</span>
                        </div>
                        <div class="w-full h-4 bg-slate-100 rounded-full overflow-hidden border border-slate-200">
                            <div id="progress-bar" class="h-full bg-emerald-500 text-[10px] font-bold text-white flex items-center justify-center transition-all duration-300" style="width: 0%;">
                            </div>
                        </div>
                    </div>

                    {{-- Filter & Options --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="opt-months" class="block text-xs font-bold text-slate-700 mb-1">Rentang Waktu Gambar:</label>
                            <select id="opt-months" class="form-control form-control-sm">
                                <option value="1">1 Bulan Terakhir</option>
                                <option value="3" selected>3 Bulan Terakhir (Direkomendasikan)</option>
                                <option value="6">6 Bulan Terakhir</option>
                                <option value="12">1 Tahun Terakhir</option>
                                <option value="0">Semua Waktu</option>
                            </select>
                        </div>

                        <div>
                            <label for="opt-batch" class="block text-xs font-bold text-slate-700 mb-1">Ukuran Batch (Per Request):</label>
                            <select id="opt-batch" class="form-control form-control-sm">
                                <option value="5">5 foto / batch (Ringan)</option>
                                <option value="15" selected>15 foto / batch (Direkomendasikan)</option>
                                <option value="30">30 foto / batch (Cepat)</option>
                            </select>
                        </div>

                        <div>
                            <label for="opt-quality" class="block text-xs font-bold text-slate-700 mb-1">Kualitas WebP:</label>
                            <select id="opt-quality" class="form-control form-control-sm">
                                <option value="70">70 - Ringan (Ukuran Terkecil)</option>
                                <option value="80" selected>80 - Seimbang (PageSpeed Optimal)</option>
                                <option value="90">90 - Tinggi (Tajam)</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="opt-keep" class="rounded border-slate-300">
                        <label for="opt-keep" class="text-xs text-slate-600 mb-0 cursor-pointer">
                            Pertahankan file JPG/PNG asli sebagai cadangan (tidak dihapus setelah konversi)
                        </label>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-wrap items-center gap-2 pt-1">
                        <button type="button" id="btn-start" class="btn btn-primary btn-sm px-4 py-2 font-bold">
                            <i class="fas fa-play mr-1"></i> Mulai Optimasi
                        </button>
                        <button type="button" id="btn-pause" class="btn btn-warning btn-sm px-4 py-2 font-bold text-white" disabled>
                            <i class="fas fa-pause mr-1"></i> Jeda
                        </button>
                        <button type="button" id="btn-refresh" class="btn btn-secondary btn-sm px-4 py-2 font-bold">
                            <i class="fas fa-sync-alt mr-1"></i> Segarkan Data
                        </button>
                    </div>

                    {{-- Real-Time Activity Log --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                <i class="fas fa-terminal text-slate-500"></i> Log Aktivitas Optimasi Real-Time:
                            </span>
                            <button type="button" id="btn-clear-log" class="text-xs font-bold text-rose-600 hover:underline bg-transparent border-0 p-0 cursor-pointer">
                                Bersihkan Log
                            </button>
                        </div>
                        <div id="optimize-log" class="bg-slate-900 text-emerald-400 font-mono text-xs p-4 rounded-xl h-56 overflow-y-auto space-y-1 shadow-inner">
                            <div>[SYSTEM] Modul Optimasi Siap. Pilih rentang bulan lalu klik "Mulai Optimasi".</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Info & CLI Card (4 cols) --}}
            <div class="lg:col-span-4 space-y-5">
                <div class="br-section-wrapper">
                    <h6 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 pb-3 mb-3 border-b border-slate-200 flex items-center gap-2">
                        <i class="fas fa-shield-halved text-emerald-600"></i> Keamanan &amp; Stabilitas
                    </h6>
                    <ul class="text-xs text-slate-600 space-y-2.5 pl-4 mb-0">
                        <li><strong>Batch Slicing:</strong> Memproses 5–30 gambar per request agar CPU &amp; RAM server tetap aman.</li>
                        <li><strong>Memory-Safe:</strong> Dilengkapi pembersihan memori PHP (<code>gc_collect_cycles</code>) setiap batch.</li>
                        <li><strong>Auto-Sync DB:</strong> Nama file di database (Post, Slider, Flyer, Galeri, Logo, dll.) diperbarui otomatis ke <code>.webp</code>.</li>
                        <li><strong>Filter Berkala:</strong> Pilih rentang bulan tertentu (misal 3 bulan terakhir) agar optimasi rutin lebih ringan.</li>
                    </ul>
                </div>

                <div class="rounded-2xl bg-slate-800 text-white p-5 shadow-sm">
                    <div class="text-xs font-extrabold uppercase tracking-wider text-amber-400 mb-2 flex items-center gap-2">
                        <i class="fas fa-terminal"></i> Optimasi Via Terminal CLI
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed mb-3">
                        Anda juga dapat menjalankan perintah Artisan di server atau crontab background:
                    </p>
                    <code id="cli-preview" class="block bg-slate-950 text-emerald-400 p-3 rounded-xl text-xs font-mono break-all">
                        php artisan images:compress-webp --months=3
                    </code>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(function () {
    var isRunning = false;
    var isPaused = false;
    var totalSavedThisSession = 0;

    function appendLog(msg, colorClass) {
        var $log = $('#optimize-log');
        var cls = colorClass || 'text-emerald-400';
        var time = new Date().toLocaleTimeString('id-ID');
        $log.append('<div class="' + cls + '">[' + time + '] ' + $('<div>').text(msg).html() + '</div>');
        $log.scrollTop($log[0].scrollHeight);
    }

    function updateUI(stats) {
        $('#stat-total').text(stats.total_files.toLocaleString('id-ID'));
        $('#stat-size').text(stats.total_size_human);
        $('#stat-webp').text(stats.webp_files.toLocaleString('id-ID'));
        $('#stat-webp-pct').text(stats.webp_percent + '% Selesai');
        $('#stat-pending').text(stats.pending_files.toLocaleString('id-ID'));
        $('#stat-save').text(stats.estimated_save_human);

        $('#progress-label').text('Kemajuan Optimasi: ' + stats.webp_percent + '%');
        $('#progress-count').text(stats.webp_files + ' / ' + stats.total_files + ' file');
        $('#progress-bar').css('width', stats.webp_percent + '%').text(stats.webp_percent > 8 ? stats.webp_percent + '%' : '');

        if (!isRunning) {
            if (stats.pending_files === 0) {
                setStatus('Semua gambar pada rentang ini sudah optimal', 'bg-emerald-50 text-emerald-700 border-emerald-200');
            } else {
                setStatus('Siap dijalankan', 'bg-cyan-50 text-cyan-700 border-cyan-200');
            }
        }
    }

    function setStatus(text, classes) {
        $('#status-badge').attr('class', 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border ' + classes).html('<i class="fas fa-circle-info"></i> ' + text);
    }

    function loadStats() {
        var months = $('#opt-months').val();
        $('#cli-preview').text('php artisan images:compress-webp --months=' + months);
        $.get('{{ route("dashboard.image_optimize.stats") }}', { months: months }, function (res) {
            updateUI(res);
        });
    }

    function runNextBatch() {
        if (!isRunning || isPaused) return;

        $.ajax({
            url: '{{ route("dashboard.image_optimize.process") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                months: $('#opt-months').val(),
                batch_size: $('#opt-batch').val(),
                quality: $('#opt-quality').val(),
                keep_originals: $('#opt-keep').is(':checked') ? 1 : 0
            },
            success: function (res) {
                if (res.logs && res.logs.length) {
                    res.logs.forEach(function (line) {
                        var cls = line.startsWith('[ERR]') ? 'text-rose-400' : (line.startsWith('[SKIP]') ? 'text-amber-300' : 'text-emerald-400');
                        appendLog(line, cls);
                    });
                }
                if (res.stats) {
                    updateUI(res.stats);
                }
                if (res.processed > 0 && res.remaining > 0 && isRunning && !isPaused) {
                    setTimeout(runNextBatch, 300);
                } else {
                    isRunning = false;
                    $('#btn-start').prop('disabled', false);
                    $('#btn-pause').prop('disabled', true);
                    $('#opt-months').prop('disabled', false);
                    setStatus('Optimasi Selesai', 'bg-emerald-50 text-emerald-700 border-emerald-200');
                    appendLog('[DONE] Proses optimasi selesai. Sisa antrean: ' + (res.remaining || 0) + ' file.', 'text-cyan-300');
                }
            },
            error: function (xhr) {
                isRunning = false;
                $('#btn-start').prop('disabled', false);
                $('#btn-pause').prop('disabled', true);
                $('#opt-months').prop('disabled', false);
                setStatus('Terjadi Kesalahan', 'bg-rose-50 text-rose-700 border-rose-200');
                appendLog('[ERROR] Request gagal (HTTP ' + xhr.status + '). Coba perkecil ukuran batch.', 'text-rose-400');
            }
        });
    }

    $('#opt-months').on('change', function () {
        loadStats();
        appendLog('[FILTER] Rentang waktu diubah ke: ' + $(this).find('option:selected').text(), 'text-sky-300');
    });

    $('#btn-refresh').on('click', function () {
        loadStats();
        appendLog('[REFRESH] Statistik gambar diperbarui.', 'text-sky-300');
    });

    $('#btn-clear-log').on('click', function () {
        $('#optimize-log').html('<div class="text-slate-400">[SYSTEM] Log dibersihkan.</div>');
    });

    $('#btn-start').on('click', function () {
        isRunning = true;
        isPaused = false;
        $(this).prop('disabled', true);
        $('#btn-pause').prop('disabled', false);
        $('#opt-months').prop('disabled', true);
        setStatus('Sedang memproses...', 'bg-blue-50 text-blue-700 border-blue-200');
        appendLog('[START] Memulai optimasi batch (' + $('#opt-months option:selected').text() + ', ' + $('#opt-batch').val() + ' foto/batch)...', 'text-cyan-300');
        runNextBatch();
    });

    $('#btn-pause').on('click', function () {
        isPaused = true;
        isRunning = false;
        $(this).prop('disabled', true);
        $('#btn-start').prop('disabled', false);
        $('#opt-months').prop('disabled', false);
        setStatus('Dijeda oleh pengguna', 'bg-amber-50 text-amber-700 border-amber-200');
        appendLog('[PAUSE] Optimasi dijeda.', 'text-amber-300');
    });

    loadStats();
});
</script>
@endpush
