<section class="mb-2">
    <div class="mb-2 text-center content-divider">
                                    <span class="px-2 d-inline-block bg-white">
                                        <h4 class="mb-0 font-weight-bold">Headline</h4>
                                    </span>
    </div>


    @foreach(App\Http\Controllers\HomeController::headlinePost('3') as $headlineside)

        <div class="card shadow-sm">
            {{--                    @if($headlineside->picture != '')--}}
            {{--                        <div class="card-img-actions">--}}
            {{--                            <img class="card-img img-fluid"--}}
            {{--                                 src="{{ berkas($headlineside->picture) }}"--}}
            {{--                                 alt="{{ $headlineside->title }}">--}}
            {{--                        </div>--}}
            {{--                    @endif--}}
            <div class="card-body">
                <div class="news-title">
                    <h5 class="font-weight-semibold font-size-sm">
                        <a class="text-default"
                           title="{{ $headlineside->title }}"
                           href="{{ url('/detail-post/'.$headlineside->seotitle) }}">{{ $headlineside->title }}</a>
                    </h5>
                    <ul class="list-inline list-inline-dotted text-muted mb-3 font-size-xs">
                        <li class="list-inline-item">{{ $headlineside->created_at->diffForHumans() }}</li>
                        <li class="list-inline-item">Dilihat {{ $headlineside->hit }}
                            kali
                        </li>
                    </ul>


                </div>
            </div>

        </div>

    @endforeach


</section>