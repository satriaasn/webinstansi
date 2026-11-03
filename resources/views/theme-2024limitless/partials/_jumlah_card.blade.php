<?php
$cposts = \App\Models\Post::where('active', 'Y')->count();

$cagendas = \App\Models\Agenda::where('active', 'Y')->count();
$cdownloads = \App\Models\Download::where('active', 'Y')->count();
$cgallerys = \App\Models\Gallery::where('active', 'Y')->count();

?>
<div class="row sum-container">
    <div class="col-12">
        <div class="card card-body bg-light has-bg-image summary-box shadow">
            <div class="media">
                <div class="media-body font-weight-semibold">
                    <h3 class="mb-0 number-style">{{number_format($cposts, 0, ',', '.')}}</h3>
                    <span>Post Berita</span>
                </div>

                <div class="ml-3 align-self-center">
                    <i class="text-dark icon-newspaper icon-4x opacity-75"></i>
                </div>
            </div>

        </div>
    </div>
    <div class="col-12">
        <div class="card card-body bg-light has-bg-image summary-box shadow">
            <div class="media">
                <div class="media-body font-weight-semibold">
                    <h3 class="mb-0 number-style">{{number_format($cgallerys, 0, ',', '.')}}</h3>
                    <span>Galeri</span>
                </div>

                <div class="ml-3 align-self-center">
                    <i class="text-dark icon-image2 icon-4x opacity-75"></i>
                </div>
            </div>

        </div>
    </div>

    <div class="col-12">
        <div class="card card-body bg-light has-bg-image summary-box shadow">
            <div class="media">
                <div class="media-body font-weight-semibold">
                    <h3 class="mb-0 number-style">{{number_format($cagendas, 0, ',', '.')}}</h3>
                    <span>Agenda</span>
                </div>

                <div class="ml-3 align-self-center">
                    <i class="text-dark icon-book icon-4x opacity-75"></i>
                </div>
            </div>

        </div>
    </div>

    <div class="col-12">
        <div class="card card-body bg-light has-bg-image summary-box shadow">
            <div class="media">
                <div class="media-body font-weight-semibold">
                    <h3 class="mb-0 number-style">{{number_format($cdownloads, 0, ',', '.')}}</h3>
                    <span>Dokumen</span>
                </div>

                <div class="ml-3 align-self-center">
                    <i class="text-dark icon-file-check icon-4x opacity-75"></i>
                </div>
            </div>

        </div>
    </div>
</div>